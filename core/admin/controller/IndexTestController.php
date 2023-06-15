<?php

namespace core\admin\controller;

use core\base\controller\BaseController;
use core\admin\model\Model;
use core\base\model\BaseModel;
use core\base\model\UserModel;
use core\base\settings\Settings;
use core\user\controller\BaseUser;

class IndexTestController extends BaseController
{
	protected function inputData()
	{
		$db = Model::instance();

		// Выпуск №17 Введение в mysql


		// реализуем связь: Один ко Многим:

		// 1) при помощи вложенных запросов
		$query = "SELECT id, name FROM product WHERE parent_id = (SELECT id FROM category WHERE name = 'Apple')";
		// 2) при помощи JOIN
		$query2 = "SELECT product.id, product.name FROM product LEFT JOIN category ON product.parent_id = category.id WHERE category.id = 1";
		// 3) получим и продукты и категории (т.к. запрашиваемые поля в таблицах называются одинаково используем 
		// псевдонимы чтобы одни не перезаписались другими в реультирующем массиве)
		$query3 = "SELECT category.id, category.name, product.id as p_id, product.name as p_name FROM product LEFT JOIN category ON product.parent_id = category.id";

		$res = $db->query($query);
		$res2 = $db->query($query2);
		$res3 = $db->query($query3);


		// реализуем связь: Многие ко Многим (с использованием третьей таблицы)
		$query4 = " SELECT teachers.id, teachers.name, students.id as s_id , students.name as s_name FROM teachers LEFT JOIN stud_teach ON teachers.id = stud_teach.teachers LEFT JOIN students ON stud_teach.students = students.id";

		$res4 = $db->query($query4);

		//=============================================================================================================//

		// Выпуск №74 Mysql связи многие ко многим (mysql many to many)

		$model = Model::instance();

		// Иы хотим получить всех учителей
		$res5 = $model->get('teachers', [
			// по условию:
			'where' => ['id' => '1,2'],
			// с указанием операнда:
			'operand' => ['IN'],

			// и узнать всех учеников у которых они ведут
			'join' => [
				// вначале мы должны связать идентификаторы(id) таблицы: teachers с соответствующим идентификатором(полем: 
				// id) таблицы(связывающей): stud_teach
				// для этого указываем: таблицу:
				'stud_teach' => [
					// и далее: по какому признаку свзываем таблицы (из табл. teachers берём поле: id, а из табл. stud_teach берём поле: teachers)
					'on' => ['id', 'teachers'],
				],
				// затем получим студентов: связываемся с соответствующей таблицей
				'students'  => [
					// применим поле: fields и уже для него укажем как значение необходимые нам поля с псевдонимыами 
					// (иначе одноимённые поля таблиц переопределятся в результирующем массиве):
					'fields' => ['id as student_id', 'name as student_name'],
					// также укажем по какому признаку взать:
					'on' => ['students', 'id']
				]
			]
		]);

		//=============================================================================================================//

		// Выпуск №77 создание метода модели для формирования псевдонимов таблиц

		// Связывание таблиц через третью(связывающую таблицу), с использованием связывания данных из одной таблицы(здесь- 
		// в таблице: filters) в которой разместили и категории фильтров и значения фильтров:		
		$res6 = $model->get('goodsnew', [
			'where' => ['id' => '79,81'],
			'operand' => ['IN'],
			'join' => [
				'goodsnew_filters' => [
					// укажем, что значения полей из таблицы с которой здесь связываемся, нам получать не надо (т.к. здесь- 
					// выводятся составные внешние ключи и показывать(выводить) их не надо, они просто для связи)
					'fields' => null,
					'on' => ['id', 'goodsnew_id ']
				],
				// получим значения фильтров для указанных товаров
				'filters f' => [
					'fields' => ['id as filter_id', 'name as filter_name'],
					'on' => ['filters_id', 'id']
				],
				// реализуем связывание данных из одной таблицы применив псевдоним в её названии при повторном обращении к ней уже в нумерованом массиве:
				// получим названия родительских категорий фильтров
				[
					'table' => 'filters',
					'on' => ['parent_id', 'id']
				]

			],
			// получим данные структурированно (иначе данные придут свалкой)
			'join_structure' => true,
			// + Выпуск №79 доработка методов модели для работы с псевдонимами таблиц

			// в сортировке можем указать ф-ю RAND() и получить рандомную(случайную) выборку и здесь уже не подразумевается
			// что мы должны задать направление сортировки, т.е. ф-ия отрабатывает сама по себе
			// при этом допускается в order и order_direction подавать не только массив, но и обычную строку (т.е. запишем не 'order' => ['RAND()'], а 'order' => 'RAND()')

			// 'order' => ['id'],
			'order' => 'id',
			// 'order_direction' => ['ASC'],
			'order_direction' => 'ASC',

		]);

		exit('Запрос');
	}
}

// Используемые методы (CRUD): 

// add (create)- добавить (создать)
// edit (update)- редактировать (обновить)
// get (read)- получить (прочитать)
// delete- удалить