<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php $this->getStyles() ?>

	<title>САЙТ ПОСТРОЕН (новости)</title>
</head>

<body>

	<header class="container-fluid" style='background: url("<?= PATH . TEMPLATE ?>assets/img/header-2-min.jpg") center center/cover no-repeat fixed;'>

		<div class="container">

			<div class="row">

				<div class="col-4">
					<a href="/"><img src="<?= PATH . TEMPLATE ?>assets/img/сайт-построен-min.png" alt="сайт построен" class="img-thumbnail" style="width: 100px; background-color: transparent; border: none"></a>
				</div>

				<nav class="col-8">
					<ul>
						<li><a href="/">Главная</a> </li>
						<li><a href="#">О нас</a> </li>
						<li><a href="#">Услуги</a> </li>

						<li>
							<?php if (isset($_SESSION['id'])) : ?>

								<a href="#">
									<i class="fa fa-user"></i>
									<?php echo $_SESSION['login']; ?>
								</a>
								<ul>
									<?php if ($_SESSION['admin']) : ?>
										<li><a href="#">Админ панель</a> </li>
									<?php endif; ?>
									<li><a href="#">Выход</a> </li>
								</ul>

							<?php else : ?>
								<a href="#">
									<i class="fa fa-user"></i>
									Войти
								</a>
								<ul>
									<li><a href="#">Регистрация</a> </li>
									<li><a href="#">Авторизация</a> </li>
								</ul>

							<?php endif; ?>

						</li>
					</ul>
				</nav>

			</div>

		</div>
	</header>

	<main class="main">