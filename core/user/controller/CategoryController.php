<?php

namespace core\user\controller;

use core\admin\model\Model;
use core\base\controller\BaseController;
use core\base\exceptions\RouteException;

class CategoryController extends BaseUser
{

	protected function inputData()
	{

		parent::inputData();

		$data = [];

		if (!empty($this->parameters['alias'])) {

			$data = $this->model->get('category', [
				'where' => ['alias' => $this->parameters['alias'], 'visible' => 1],
			]);

			if (!$data) {

				throw new RouteException('Не найдены записи в таблице category по ссылке ', $this->parameters['alias']);
			}

			$data = $data[0];
		}

		// сформируем инструкцию для статей
		$where = ['visible' => 1];

		if ($data) {

			// Выпуск №144
			$where['parent_id'] = $data['id'];
		} else {

			$data['name'] = 'Все статьи';
		}


		// Получим товары (с их фильтрами и ценами):

		$articles = $this->model->get('articles', [
			'where' => $where,
			'operand' => ['='],
			'order' => ['datetime'],
			'pagination' => [
				'qty' => QTY,
				'page' => $this->clearNum($_GET['page'] ?? 1) ?: 1
			]
		]);

		// Выпуск №136
		$pages = $this->model->getPagination();


		return compact('data', 'articles', 'pages');
	}
}
