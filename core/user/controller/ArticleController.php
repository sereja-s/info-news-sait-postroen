<?php

namespace core\user\controller;

use core\admin\model\Model;
use core\base\controller\BaseController;
use core\base\exceptions\RouteException;

class ArticleController extends BaseUser
{

	protected function inputData()
	{

		parent::inputData();

		if (empty($this->parameters['alias'])) {

			throw new RouteException('Отсутствует ссылка на статью', 3);
		}

		$data = $this->model->get('articles', [
			'where' => ['alias' => $this->parameters['alias'], 'visible' => 1]
		]);

		if (!$data) {

			throw new RouteException('Отсутствует статья по ссылке ' . $this->parameters['alias']);
		}

		$data = array_shift($data);

		return compact('data');
	}
}
