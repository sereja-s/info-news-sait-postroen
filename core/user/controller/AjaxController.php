<?php

namespace core\user\controller;

use core\base\controller\BaseAjax;

/**
 * Ajax-контроллер пользовательской части (Выпуск №67) (+Выпуск №134) 
 */
class AjaxController extends BaseUser
{
	public function ajax()
	{
		// Выпуск №134
		if (isset($this->ajaxData['ajax'])) {

			$this->inputData();

			foreach ($this->ajaxData as $key => $item) {

				$this->ajaxData[$key] = $this->clearStr($item);
			}

			switch ($this->ajaxData['ajax']) {

					// Выпуск №134- Пользовательская часть | Выбор количества товаров показываемых в каталоге
				case 'catalog_quantities':

					$qty =  $this->clearNum($this->ajaxData['qty'] ?? 0);

					$qty && $_SESSION['quantities'] = $qty;

					break;

					// Выпуск №139 | Пользовательская часть | Добавление в корзину | часть 1
				case 'add_to_cart';

					return $this->_addToCart();

					break;

					// php | js | поиск по каталогу
				case 'search':
					return $this->search();
					break;
			}
		}

		return json_encode(['success' => '0', 'message' => 'No ajax variable']);
	}

	/** 
	 * Метод работы поиска по каталогу( Выпуск №105)
	 */
	protected function search()
	{
		// получили то что введено в поисковую строку
		$data = $this->clearStr($this->ajaxData['data']);

		// получили то где ищем (приоритет поиска)
		$table = $this->clearStr($this->ajaxData['table']);

		// вызовем метод модели
		// здесь 3-ий параметр это кол-во подсказок (ссылок) показываемых при работе с поисковой строкой
		return $this->model->search($data, $table, 20);
	}

	/** 
	 * метод добавит в корзину (Выпуск №139, 140)
	 */
	protected function _addToCart()
	{

		//return $this->ajaxData['qty'];

		return $this->addToCart($this->ajaxData['id'] ?? null, $this->ajaxData['qty'] ?? 1);
	}
}
