<?php

// условие: если константа безопасности VG_ACCESS установлена (т.е. вернёт true), то код ниже условия выполнится, иначе вернёт (покажет): Access denied (доступ запрещён)
defined('VG_ACCESS') or die('Access denied');

// константа в значении: false не разрешает работу с браузером Microsoft (Выпуск №91)
const MS_MODE = false;

// константа для хранения пути к пользовательской части сайта
const TEMPLATE = 'templates/default/';
// константа для хранения пути к административной панели сайта
const ADMIN_TEMPLATE = 'core/admin/view/';

// константа, указывающая директорию где у нас будут храниться загружаемые файлы
const UPLOAD_DIR = 'userfiles/';

// константа, указывающая директорию где у нас будут храниться изображения используемые по умолчанию (Выпуск №120)
const DEFAULT_IMAGE_DIRECTORY = 'default_images';

// константа для хранения версии куки файлов (версия выбирается произвольно)
const COOKIE_VERSION = '1.0.0';

// константа для хранения ключа шифрования для куки файлов
// генерируем ключ в генераторе ключей для AES-128 (используемый здесь метод шифрования) Генератор находим в 
// поисковике браузера 
// Переходим по ссылке: https://www.allkeysgenerator.com/Random/Security-Encryption-Key-Generator.aspx
// выбираем: Security level- 128-bit Чтобы ключ был посложнее выбираем: How many ?- 5 (по желанию можно и больше)
// копируем их и вставляем в const CRYPT_KEY в качестве суммарного ключа (равняем в строку)
const CRYPT_KEY = 't7w!z%C&F)J@NcRfYq3t6w9z$B&E)H@MgVkYp3s6v9y$B?E(NdRgUkXp2s5v8y/B)J@NcRfUjXn2r5u8t7w!z%C&F)J@NcRfYq3t6w9z$B&E)@MgVkYp3s6v9y$B?E/';

// константа для хранения времени в мин. (ограничение бездействия администратора), по истечении которого его выкинет из админки (разлогинит)
const COOKIE_TIME = 1600;

// константа для хранения времени в мин. на которое заблокирует пользователя при попытке подобрать пароль к сайту
const BLOCK_TIME = 3;

// константа для хранения конечного слеша (Выпуск №121)
const END_SLASH = '/';

// Kонстанты для постраничной навигации:

/** 
 * кол-во отображения товаров на странице
 */
const QTY = 18;
/** 
 * кол-во ссылок постраничной навигации (левее и правее активной)
 */
const QTY_LINKS = 2;

/** 
 * константа отвечающая за то, где мы будем хранить корзину (имеет 2-а значения: куки, а всё остальное-сесии) Выпуск №140
 */
const CART = 'cookie';

// константа для хранения путей css- и js-файлов административной панели сайта
const ADMIN_CSS_JS = [
	// ячейка массива styles отвечает за css-файлы
	'styles' => ['css/main.css'],
	// ячейка массива scripts отвечает за js-файлы
	'scripts' => [
		'js/frameworkfunctions.js',
		'js/scripts.js',
		'js/tinymce/tinymce.min.js',
		'js/tinymce/tinymce_init.js'
	]
];

//  константа для хранения путей css- и js-файлов пользовательской части сайта 
const USER_CSS_JS = [
	// + в файле header.php вместо стилей указать:
	// <?php $this->getStyles() ?
	'styles' => [
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
		'https://use.fontawesome.com/releases/v5.7.2/css/all.css',
		'https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap',
		'assets/css/style.css'
	],
	// + в файле footer.php вместо скриптов указать:
	// <?php $this->getScripts() ?
	'scripts' => [
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
		'assets/js/scripts.js',
	]
];

use core\base\exceptions\RouteException;


function autoloadMainClasses($class_name)
{
	// в переменной сохраняем результат работы функции str_replace(), которая поменяет все встречающиеся в переменной $class_name (указана 3-им параметром), знаки \ (в ф-ции он экранирован) на знак /
	$class_name = str_replace('\\', '/', $class_name);

	// условие: если не подключается данный файл
	// (знак @ блокирует вывод ошибок, которые генерирует функция, когда пытается подключить файл и его подключить не может)
	if (!include_once ($class_name) . '.php') {

		// небходимо выбросить исключение с указанным текстом сообщения
		// (конструкция throw ищет ближайший catch класса RouteException (здесь это в файле catch))
		throw new RouteException('Не верное имя файла для подключения: ' . $class_name);
	}
}

// функция автоматической загрузки классов
spl_autoload_register('autoloadMainClasses');


// Выпуск №152 | Пользовательская часть | отправка уведомлений на email
// для подключения композером своих файлов для автозагрузки загруженных пакетов(библиотек) 
if (is_readable('vendor/autoload.php')) {

	include 'vendor/autoload.php';
}
