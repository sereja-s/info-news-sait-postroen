<?php

namespace core\user\helpers;

// Выпуск №145
trait ValidationHelper
{
	/** 
	 * Метод валидации формы на пустое поле
	 * 
	 * на вход: 1- какое-то значение, 2- какой-то ответ
	 */
	protected function emptyField($value, $answer)
	{
		$value = $this->clearStr($value);

		if (empty($value)) {

			$this->sendError('Не заполнено поле ' . $answer);
		}

		return $value;
	}

	/** 
	 * Метод подготавливает числовые значения при регистрации (авторизации) пользователя и т.д.
	 */
	protected function numericField($value, $answer)
	{
		// все не цифры заменим на пустую строку в значении: $value
		$value = preg_replace('/\D/', '', $value);

		// Если выражение слева от оператора выполняется успешно (возвращает true), то мы переходим к следующему условию
		!$value && $this->sendError('Некорректное поле',  $answer);

		return $value;
	}

	/** 
	 * Метод подготавливает телефонные номера и приводит к одному формату
	 */
	protected function phoneField($value, $answer = null)
	{
		$value = preg_replace('/\D/', '', $value);

		// проверка на кол-во цифр в тел.номере Если стандартное(11), то произведём замену 8-ки в начале на 7 (для удобства дальнейшего использоания тел.номера)
		if (strlen($value) === 11) {

			$value = preg_replace('/^8/', '7', $value);
		}

		return $value;
	}

	/** 
	 * Метод подготавливает email и проверяет на корректность формата
	 */
	protected function emailField($value, $answer)
	{
		$value = $this->clearStr($value);

		// ^ - начало строки;  \w - любая цифра, буква или знак подчеркивания
		if (!preg_match('/^[\w\-\.]+@[\w\-]+\.[\w\-]+/', $value)) {

			$this->sendError('Некорректный формат поля ' . $answer);
		}

		return $value;
	}

	/** 
	 * Метод выводит сообщение об ошибке
	 */
	protected function sendError($text, $class = 'error')
	{
		$_SESSION['res']['answer'] = '<div class="' . $class . '">' . $text . '</div>';

		if ($class === 'error') {

			// все данные добавим в сессию (метод описан в trait BaseMethods)
			$this->addSessionData();
		}

		// Выпуск №154 | Пользовательская часть | регистрация
		//$this->redirect();
	}

	/** 
	 * Метод выводит сообщение об успехе
	 */
	protected function sendSuccess($text, $class = 'success')
	{

		$this->sendError($text, $class);
	}
}
