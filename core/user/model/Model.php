<?php

namespace core\user\model;

use core\base\controller\Singleton;
use core\base\exceptions\RouteException;
use core\base\settings\Settings;

/** 
 * Пользовательская модель (Выпуск №120)
 * Методы: public function getGoods(); public function applyDiscount();
 */
class Model extends \core\base\model\BaseModel
{

	use Singleton;

	/** 
	 * Метод модели для получения каталога товаров (Выпуск №125)
	 * 1-ый параметр (настройки): $set = [] (принимает), 
	 * 2-ой (фильтры каталога) и 3-ий (цены каталога): &$catalogFilters = null и &$catalogPrices = null (возвращает по ссылке)
	 */
	public function getGoods($set = [], &$catalogFilters = null, &$catalogPrices = null, &$catalogCat = null)
	{
		// получим товары с id (для этого используется метод: protected function joinStructure() из BaseModelMethods, 
		// который запускается если есть ячейка: ['join_structure'] при этом вернётся массив вида: id товара => данные 
		// товара) Поэтому делаем следующую проверку:
		if (empty($set['join_structure'])) {

			$set['join_structure'] = true;
		}

		// в $set['where'] должен быть массив
		if (empty($set['where'])) {

			$set['where'] = [];
		}


		// соберём сортировку товаров по умолчанию
		if (empty($set['order'])) {

			$set['order'] = [];

			// если не пусто в таблице: goodsnew в ячейке: parent_id
			if (!empty($this->showColumns('goodsnew')['parent_id'])) {

				// то в начале будем сортировать по ней
				$set['order'][] = 'parent_id';
			}

			// аналогично делаем для ячейки: price
			if (!empty($this->showColumns('goodsnew')['price'])) {

				$set['order'][] = 'price';
			}
		}

		// получим товары (при этом подаём уже обработанный $set)		
		$goodsnew = $this->get('goodsnew', $set);

		// все дальнейшие действия выполняем если пришли товары
		if ($goodsnew) {

			if (!empty($this->showColumns('goodsnew')['discount'])) {

				foreach ($goodsnew as $key => $item) {

					$this->applyDiscount($goodsnew[$key], $item['discount']);
				}
			}

			// разрегистрируем ячейки:
			unset($set['join'], $set['join_structure'], $set['pagination']);


			// Получим цены:

			if ($catalogPrices !== false && !empty($this->showColumns('goodsnew')['price'])) {

				// MIN() и MAX()- функции SQL
				$set['fields'] = ['MIN(price) as min_price', 'MAX(price) as max_price'];

				// получим в переменную: массив с min_price(мин.цена) и max_price(макс.цена) товара из таблицы БД: goodsnew
				$catalogPrices = $this->get('goodsnew', $set);

				if (!empty($catalogPrices[0])) {

					$catalogPrices = $catalogPrices[0];
				}
			}

			//$a = 1;


			// Получим фильтры:

			if ($catalogFilters !== false && in_array('filters', $this->showTables())) {

				// родительские названия фильтров
				$parentFiltersFields = [];

				// блок условий
				$filtersWhere = [];

				// блок сортировки
				$filtersOrder = [];

				// получим все данные родителя(название фильтра) и ребёнка(значения фильтра) в распределённом виде
				foreach ($this->showColumns('filters') as $name => $item) {

					// по условию забираем названия полей только те, которые являются массивом
					if (!empty($item) && is_array($item)) {

						// в поля собираем названия
						$parentFiltersFields[] = $name . ' as f_' . $name; // что бы отличать родителя от значения, укажем им псевдоним
					}
				}


				// если есть соответствующая ячейка: visible
				if (!empty($this->showColumns('filters')['visible'])) {

					// в блоке условий установим начение:
					$filtersWhere['visible'] = 1;
				}

				// если есть соответствующая ячейка: menu_position
				if (!empty($this->showColumns('filters')['menu_position'])) {

					// в блок сортировки запишем:
					$filtersOrder[] = 'menu_position';
				}


				// получаем фильтры
				$filters = $this->get('filters', [
					'where' => $filtersWhere,
					'join' => [
						// соединяем таблицу с самой собой
						'filters f_name' => [
							'type' => 'INNER',  // т.к. нам не нужно чтобы приходило значение если нет родителя
							'fields' => $parentFiltersFields,
							'where' => $filtersWhere,
							// укажем признак (из предыдущей таблицы- поле: parent_id смотрит на текущую- поле: id)
							'on' => ['parent_id', 'id']
						],
						// нам нужен джоин(связь) с таблицей связей
						'goodsnew_filters' => [
							// применим расширенный режим (с указанием ключа: 'on') т.к. смотрим не на предыдущую таблицу (здесь- filters f_name), а на другую(здесь- filters)
							'on' => [
								'table' => 'filters',
								// поле из предыдущей таблицы (id) должно смотреть на поле текущей (filters_id)
								'fields' => ['id', 'filters_id']
							],
							'where' => [
								// строим подзапрос (вложенный запрос), так блок с фильтрами нужно получить для всех товаров в 
								// разделе Буем искать: goodsnew_id (т.е. полуим идентификаторы всех товаров (т.к. блок с фмльтрами 
								// нам надо получить для всех товаров), имеющихся в разделе, согласно условию: where)
								'goodsnew_id' => $this->get('goodsnew', [
									'fields' => [$this->showColumns('goodsnew')['id_row']],
									'where' => $set['where'] ?? null,
									// Выпуск №132
									'operand' => $set['operand'] ?? null,
									'return_query' => true
								])
							],

							'operand' => ['IN'],
						]
					],

					// 'return_query' => true
				]);

				// Сделаем подсчёт количества товаров в конкретном фильтре (относительно категории в которой находимся) отдельным запросом:

				if ($filters) {

					// implode() — объединение элементов массива со строкой
					// (Возвращает строку, содержащую строковое представление всех элементов массива в одном порядке со 
					// строкой-разделителем (здесь- запятая) между каждым элементом)
					// array_column() — возвращает значения из одного столбца во входном массиве

					// Получим все уникальные id для фильтров и товаров из массива в переменной: $filters

					$filtersIds = implode(',', array_unique(array_column($filters, 'id')));

					$goodsIds = implode(',', array_unique(array_column($filters, 'goodsnew_id')));

					$query = "SELECT `filters_id` as id, COUNT(goodsnew_id) as count FROM goodsnew_filters WHERE filters_id IN ($filtersIds) AND goodsnew_id IN ($goodsIds) GROUP BY filters_id";

					// количество товаров в конкретных фильтрах (относительно категории в которой находимся) отдельным запросом (придёт: id для каждого фильтра и кол-во товаров, для которых он применён):
					$goodsCountDb = $this->query($query);

					// $a = 1;

					$goodsCount = [];

					if ($goodsCountDb) {

						foreach ($goodsCountDb as $item) {

							// в ячейку с ключём: id (для каждого фильтра) положим значение (массив): его id и кол-во товаров, для которых он применён
							$goodsCount[$item['id']] = $item;
						}
					}


					// формируем фильтр каталога
					$catalogFilters = [];

					// пересоберём данные в переменой: $filters
					foreach ($filters as $item) {

						$parent = [];

						$child = [];

						foreach ($item as $row => $rowValue) {

							// определим родительскую категорию (в массиве: её данные с префиксом: f_): фильтр
							if (strpos($row, 'f_') === 0) {

								$name = preg_replace('/^f_/', '', $row);

								// в ячейку с именем родителя положим его значение
								$parent[$name] = $rowValue;

								// иначе это данные дочерней категории: значения фильтра
							} else {

								// в ячейку с именем дочерней категории положим соответственно её значение
								$child[$row] = $rowValue;
							}
						}


						if (isset($goodsCount[$child['id']]['count'])) {

							$child['count'] = $goodsCount[$child['id']]['count'];
						}

						if (empty($catalogFilters[$parent['id']])) {

							$catalogFilters[$parent['id']] = $parent;

							// создадим элемент для сбора значений фильтров
							$catalogFilters[$parent['id']]['values'] = [];
						}


						// сформируем фильтры
						$catalogFilters[$parent['id']]['values'][$child['id']] = $child;

						if (isset($goodsnew[$item['goodsnew_id']])) {

							if (empty($goodsnew[$item['goodsnew_id']]['filters'][$parent['id']])) {

								$goodsnew[$item['goodsnew_id']]['filters'][$parent['id']] = $parent;
								$goodsnew[$item['goodsnew_id']]['filters'][$parent['id']]['values'] = [];
							}

							$goodsnew[$item['goodsnew_id']]['filters'][$parent['id']]['values'][$item['id']] = $child;
						}
					}
				}
			}



			// сформируем категории с вложенностями (подкатегориями)

			/* if ($catalogCat !== false && in_array('category', $this->showTables())) {

				// родительские названия фильтров
				$parentCategoryFields = [];

				// блок условий
				$categoryWhere = [];

				// блок сортировки
				$categoryOrder = [];

				// получим все данные родителя(название категории) и его подкатегории в распределённом виде
				foreach ($this->showColumns('category') as $name => $item) {

					// по условию забираем названия полей только те, которые являются массивом
					if (!empty($item) && is_array($item)) {

						// в поля собираем названия
						$parentCategoryFields[] = $name . ' as cat_' . $name; // что бы отличать родителя от значения, укажем им псевдоним
					}
				}


				// если есть соответствующая ячейка: visible
				if (!empty($this->showColumns('category')['visible'])) {

					// в блоке условий установим начение:
					$categoryWhere['visible'] = 1;
				}

				// если есть соответствующая ячейка: menu_position
				if (!empty($this->showColumns('category')['menu_position'])) {

					// в блок сортировки запишем:
					$categoryOrder[] = 'menu_position';
				}


				// получаем подкатегории товаров с привязкой к категориям
				$category = $this->get('category', [
					'where' => $categoryWhere,
					'join' => [
						// соединяем таблицу с самой собой
						'category cat_name' => [
							'type' => 'INNER',  // т.к. нам не нужно чтобы приходило значение если нет родителя
							'fields' => $parentCategoryFields,
							'where' => $categoryWhere,
							// укажем признак (из предыдущей таблицы- поле: parent_id смотрит на текущую- поле: id)
							'on' => ['parent_id', 'id']
						],
						// нам нужен джоин(связь) с таблицей связей
						'goodsnew_category' => [
							// применим расширенный режим (с указанием ключа: 'on') т.к. смотрим не на предыдущую таблицу (здесь- filters f_name), а на другую
							'on' => [
								'table' => 'category',
								// получим поле(id) из предыдущей таблицы(здесь- category) должно смотреть на поле(category_id) 
								// текущей(здесь- goodsnew_category) 
								'fields' => ['id', 'category_id']
							],
							'where' => [
								// строим подзапрос (вложенный запрос) Будем искать: goodsnew_id (т.е. полуим идентификаторы 
								// всех товаров (т.к. блок с категориями нам надо получить для всех товаров), имеющихся в разделе, согласно условию: where)
								'goodsnew_id' => $this->get('goodsnew', [
									'fields' => [$this->showColumns('goodsnew')['id_row']],
									'where' => $set['where'] ?? null,
									// Выпуск №132
									'operand' => $set['operand'] ?? null,
									'return_query' => true
								])
							],

							'operand' => ['IN'],
						]
					],

					// 'return_query' => true
				]);

				// Сделаем подсчёт количества товаров в конкретной категории (в которой находимся) отдельным запросом:

				if ($category) {

					// implode() — объединение элементов массива со строкой
					// (Возвращает строку, содержащую строковое представление всех элементов массива в одном порядке со 
					// строкой-разделителем (здесь- запятая) между каждым элементом)
					// array_column() — возвращает значения из одного столбца во входном массиве

					// Получим все уникальные id для категорий из массива в переменной: $category
					$categoryIds = implode(',', array_unique(array_column($category, 'id')));

					// Получим все уникальные id товаров в категориях из массива в переменной: $category
					$goodsIdscat = implode(',', array_unique(array_column($category, 'goodsnew_id')));

					$queryCat = "SELECT `category_id` as id, COUNT(goodsnew_id) as count FROM goodsnew_category WHERE category_id IN ($categoryIds) AND goodsnew_id IN ($goodsIdscat) GROUP BY category_id";

					// количество товаров в конкретных категориях (относительно категории в которой находимся) отдельным запросом (придёт: id категории и кол-во товаров в этой категории):
					$goodsCountCatDb = $this->query($queryCat);

					$goodsCountCat = [];

					if ($goodsCountCatDb) {

						foreach ($goodsCountCatDb as $item) {

							// в ячейку с ключём: id (для каждой категории) положим значение (массив): id категории и кол-во товаров в ней
							$goodsCountCat[$item['id']] = $item;
						}
					}


					// формируем категории каталога
					$catalogCat = [];

					// пересоберём данные в переменой: $category
					foreach ($category as $item) {

						$parent = [];

						$child = [];

						// пробежимся в цикле по всем полям данной категории
						foreach ($item as $row => $rowValue) {

							// определим родительскую категорию (в массиве: её данные с префиксом: cat_)
							if (strpos($row, 'cat_') === 0) {

								$name = preg_replace('/^cat_/', '', $row);

								// в ячейку с именем родителя положим его значение
								$parent[$name] = $rowValue;

								// иначе это данные дочерней категории: значения категории
							} else {

								// в ячейку с именем дочерней категории положим соответственно её значение
								$child[$row] = $rowValue;
							}
						}


						if (isset($goodsCountCat[$child['id']]['count'])) {

							$child['count'] = $goodsCountCat[$child['id']]['count'];
						}

						if (empty($catalogCat[$parent['id']])) {

							$catalogCat[$parent['id']] = $parent;

							// создадим элемент для сбора значений категорий и инициализируем его пустым массивом
							$catalogCat[$parent['id']]['values'] = [];
						}


						// сформируем в категориях(родителях) их подкатегории(детей)
						$catalogCat[$parent['id']]['values'][$child['id']] = $child;

						if (isset($goodsnew[$item['goodsnew_id']])) {

							if (empty($goodsnew[$item['goodsnew_id']]['category'][$parent['id']])) {

								// создаём в соотвуествующем товаре ячейку: category, а в неё ячейку, соответствующую id 
								// родительской категории товара и кладём туда массив с полями этой категории 
								$goodsnew[$item['goodsnew_id']]['category'][$parent['id']] = $parent;
								// и уже там создаём ячейку: values(для массивов полей дочерних категорий(подкатегорий)) в 
								// которую пока положим пустой массив
								$goodsnew[$item['goodsnew_id']]['category'][$parent['id']]['values'] = [];
							}

							// в ячейку: values будут собраны все дочерние категории(подкатегории) которым принадлежит данный товар (с указанием кол-ва)
							$goodsnew[$item['goodsnew_id']]['category'][$parent['id']]['values'][$item['id']] = $child;
						}
					}
				}
			} */
		}

		return $goodsnew ?? null;
	}

	/** 
	 * Метод применения скидок (Выпуск №126)
	 */
	public function applyDiscount(&$data, $discount)
	{
		// +Выпуск №150 | Пользовательская часть | сохранение товаров заказа
		if (!empty($this->showColumns('goodsnew')['discount'])) {

			$data['old_price'] = null;
		}

		if ($discount) {

			$data['old_price'] = $data['price'];

			$data['discount'] = $discount;

			$data['price'] = $data['old_price'] - ($data['old_price'] / 100 * $discount);

			// округлим цену до целого значения
			$data['price'] = round($data['price']);
		}
	}


	/** 
	 * Метод работы с поиском по каталогу товаров
	 * (на вход: 1- получили то что введено в поисковую строку, 2- получили то где ищем (приоритет поиска), 
	 * 3-ий параметр- кол-во показываемых подсказок (ссылок)) 
	 */
	public function search($data, $currentTable = false, $qty = false)
	{
		// получим все таблицы из БД
		$dbTables = $this->showTables();

		// экранируем слешами (для корректного поиска)
		$data = addslashes($data);

		// разбираем поисковую строку и строим поисковый массив (систему уточнений)
		// (т.е. сначала ищем всю строку (длину), потом ищем уменьшенную на один элемент и т.д)

		$arr = preg_split('/(,|\.)?\s+/', $data, 0, PREG_SPLIT_NO_EMPTY);

		// Сформируем поисковый массив (в каждом следующем его элементе поисковая фраза будет представлена в виде строки, 
		// уменьшенной на одно значение(считается по разделителю(пробел)) с конца )

		$searchArr = [];

		$order = [];

		//  запустим цикл без условий
		for (;;) {

			if (!$arr) {

				break;
			}

			// implode()- Возвращает строку, содержащую строковое представление всех элементов массива в одном порядке со 
			// строкой-разделителем (необязательный параметр. По умолчанию используется пустая строка) между каждым элементом
			$searchArr[] = implode(' ', $arr);

			// удаляем последний элемент
			unset($arr[count($arr) - 1]);
		}


		// определим переменную (флаг) и установим ей значение по умолчанию (Выпуск №108)
		// (понадобится при выводе подсказок поиска с приоритетом той таблицы (категории) из которой осуществляется поиск)
		$correctCurrentTable = false;

		// получим свойство с таблицами проекта, в которых будет проходить поиск (связующие и т.д. исключаются) Св-во
		// применяется для проверки: существует ли указанная в нём таблица в БД 
		//$projectTables = Settings::get('projectTables');
		$searchProjectTables = Settings::get('searchProjectTables');

		if (!$searchProjectTables) {
			throw new RouteException('Ничего не найдено по вашему запросу');
		}

		foreach ($searchProjectTables as $table => $item) {

			// проверка на существование таблицы в БД
			if (!in_array($table, $dbTables)) {
				continue;
			}

			// массив полей в которых будем искать
			$searchRows = [];

			// массив по которому будем сортировать (здесь- указали поле: name, но кол-во полей для сортировки можно менять)
			$orderRows = ['name'];

			// массив полей по которым будем искать
			$fields = [];

			// поля, которые есть в БД (в таблице поднанной на вход)
			$columns = $this->showColumns($table);

			// поля, которые понадобятся для поиска (поле с первичным ключом)
			$fields[] = $columns['id_row'] . ' as id';


			// +Выпуск №113
			// сформируем переменую с названием поля для выпадающего меню с результатом поиска:
			// если существует ячейка: $columns['name'], то будем исползовать конструкцию: CASE и через WHEN и THEN 
			// заполнять поле: name из таблицы по указанным условиям (здесь- если имя не равно пустой строке, то в 
			// переменную: $fieldName сохраним строку с именем (и названием таблицы впереди) иначе - пустую строку )

			// Инструкция CASE проходит через условия и возвращает значение, когда выполняется первое условие
			// (перевод: WHEN-как только (выполнится условие), THEN-тогда вернётся указанное значение)
			$fieldName = isset($columns['name']) ? "CASE WHEN {$table}.name <> '' THEN {$table}.name " : '';

			foreach ($columns as $col => $value) {

				// stripos — Возвращает позицию первого вхождения подстроки без учёта регистра
				if ($col !== 'name' && stripos($col, 'name') !== false) {

					if (!$fieldName) {

						$fieldName = 'CASE ';
					}

					// +Выпуск №113
					$fieldName .= "WHEN {$table}.$col <> '' THEN {$table}.$col ";
				}

				// формируем поля в которых будем искать (здесь- по текстовому признаку (по вхождению в тип поля слов: char или text))
				if (
					isset($value['Type']) &&
					(stripos($value['Type'], 'char') !== false ||
						stripos($value['Type'], 'text') !== false)
				) {

					$searchRows[] = $col;
				}
			}

			if ($fieldName) {

				// сохраним в массиве, то что пришло в переменную и закроем конструкцию: CASE (описана выше) конструкцией: END и далее укажем: как псевдоним имени
				$fields[] = $fieldName . 'END as name';

				// иначе (если в $fieldName ничего не пришло)
			} else {

				// сохраним в массиве идентификатор как псевдоним имени
				$fields[] = $columns['id_row'] . ' as name';
			}


			// чтобы понимать из какой таблицы получены данные (исходя из этого значения будем формировать алиас)
			// добавим в массив ещё поле (с названием таблицы)
			$fields[] = "('$table') AS table_name";


			// здесь- формируем массивы: where и order для использования их в buildUnion (методе-построителе Union- запросов )
			$res = $this->createWhereOrder($searchRows, $searchArr, $orderRows, $table);


			$where = $res['where'];

			// если $order ещё не заполнялось
			!$order && $order = $res['order'];



			if ($table === $currentTable) {

				$correctCurrentTable = true;

				// только для такой таблицы добавим ещё одно поле
				$fields[] = "('$currentTable') AS current_table";
			}


			if ($where) {

				if ($table === 'goodsnew') {

					$this->buildUnion($table, [
						'fields' => $fields,
						'where' => $where,
						'join' => [
							'category' => [
								'fields' => ['name as category_name'],
								'on' => ['parent_id', 'id']
							]
						]
					]);
				} else {

					// обратимся к методу модели для формирования UNION запросов к базе данных (Выпуск №111)
					$this->buildUnion($table, [
						'fields' => $fields,
						'where' => $where,
						'no_concat' => true
					]);
				}
			}
		}

		//$this->test();

		$orderDirection = null;

		// сформируем: $order (для случая, когда мы находимся в таблице, которая в приоритете поиска)
		if ($order) {

			// если correctCurrentTable имеет значение: true, зачит мы используем выбранную таблицу (применяется поиск по 
			// админке с приоритетом таблицы)
			$order = ($correctCurrentTable ? 'current_table DESC, ' : '') . '(' . implode('+', $order) . ')';

			$orderDirection = 'DESC';
		}

		// Выпуск №112- ORM builder UNION запросов ч.2
		$result = $this->getUnion([
			//'type' => 'all',
			//'pagination' => [],
			//'limit' => 3,
			'order' => $order,
			'order_direction' => $orderDirection
		]);

		//$a = 1;

		// произведём вывод поиска (подсказки (ссылки)) (+Выпуск №113)

		if ($result) {

			foreach ($result as $index => $item) {

				// корректно сформируем name вида: название (название соответствующей таблицы) для вывода подсказок
				$result[$index]['name'] .=  ' ' . '(' .	(isset($searchProjectTables[$item['table_name']]['name'])
					? $searchProjectTables[$item['table_name']]['name']
					: $item['table_name']) . ')';


				// сформируем готовый алиас на редактирование

				$alias = $this->get($item['table_name'], [
					'where' => ['id' => $item['id']],
				]);

				if ($item['table_name'] === 'goodsnew') {

					$result[$index]['alias'] = PATH . 'product' . '/' . $alias[0]['alias'];
				} elseif ($item['table_name'] === 'category') {
					$result[$index]['alias'] = PATH . 'catalog' . '/' . ($alias[0]['alias'] ? $alias[0]['alias'] : '');
				} else {
					$result[$index]['alias'] = PATH . $item['table_name'] . '/' . $alias[0]['alias'];
				}
			}
		}

		return $result ?: [];
	}

	/** 
	 * Метод для формирования инструкций WHERE и ORDER для системы поиска	 
	 * (на вход: 1- массив полей в которых будем искать, 2- массив того, что мы ищем, 3- массив по которому сортируем, 
	 * 4- таблица в которой ищем) 
	 */
	protected function createWhereOrder($searchRows, $searchArr, $orderRows, $table)
	{
		$where = '';
		$order = [];

		if ($searchRows && $searchArr) {

			$columns = $this->showColumns($table);

			if ($columns) {

				// определи первую скобку в инструкции: where
				$where = '(';

				foreach ($searchRows as $row) {

					// на каждой итерации добавляем ещё одну скобку (будут группы запросов)
					$where .= '(';

					foreach ($searchArr as $item) {

						if (in_array($row, $orderRows)) {

							// символ: %- означает искать и до и после
							$str = "($row LIKE '%$item%')";

							if (!in_array($str, $order)) {

								$order[] = $str;
							}
						}


						// +Выпуск №113
						if (isset($columns[$row])) {

							$where .= "{$table}.$row LIKE '%$item%' OR ";
						}
					}


					// preg_replace() — поиск и замена регулярных выражений
					// на вход: 1- шаблон (регулярное выражение) для поиска, 2- строка (или массив со строками) для замены
					// 3- строка или массив со строками для поиска и замены (где ищем)
					$where = preg_replace('/\)?\s*or\s*\(?$/i', '', $where) . ') OR ';
				}

				// обработаем переменную ещё раз (обрежем лишний OR с пробелом в конце и добавим закрыващую скобку в конце запроса)
				$where && $where = preg_replace('/\s*or\s*$/i', '', $where) . ')';
			}
		}

		return compact('where', 'order');
	}
}
