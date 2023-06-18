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

				throw new RouteException('Не найдены записи в таблице catalog по ссылке ', $this->parameters['alias']);
			}
		}
	}
}
