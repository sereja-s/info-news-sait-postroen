<?php

namespace core\user\controller;

/** 
 * Индексный контроллер пользовательской части
 */
class IndexController extends BaseUser
{
	protected function inputData()
	{

		// Выпуск №120
		parent::inputData();

		// Выпуск №124- Пользовательская часть | вывод акций (слайдер под верхним меню)
		/* $sales = $this->model->get('sales', [
			'where' => ['visible' => 1],
			'order' => ['menu_position']
		]); */

		// Выпуск №128 - массив преимуществ
		/* $advantages = $this->model->get('advantages', [
			'where' => ['visible' => 1],
			'order' => ['menu_position'],
			'limit' => 6
		]); */

		// Выпуск №128 | Вывод новостей
		$newArticles = $this->model->get('articles', [
			'where' => ['visible' => 1],
			'order' => ['datetime'],
			'order_direction' => ['DESC'],
			'limit' => 3
		]);

		$articles = [];

		$articles['hit'] = $this->model->get('articles', [
			'where' => ['hit' => 1, 'visible' => 1],
			'order' => ['datetime'],
			'order_direction' => ['DESC'],
			'limit' => 5
		]);


		// собираем переменные в массив и возвращаем в шаблон, что бы они стали доступными при выводе
		return compact('articles', 'newArticles');
	}
}
