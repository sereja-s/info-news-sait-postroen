<?php

namespace core\user\controller;

use core\admin\model\Model;
use core\base\controller\BaseController;


class NewsController extends BaseUser
{

	protected $news;

	protected function inputData()
	{

		parent::inputData();

		$this->news = $this->model->get('news', [
			'where' => ['visible' => 1],
			'order' => ['date'],
			'order_direction' => ['DESC'],
			'limit' => 5
		]);
	}
}
