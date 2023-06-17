<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php $this->getStyles() ?>

	<title><?= $this->set['name'] ?> (новости)</title>
</head>

<body>

	<header class="container-fluid" style='background: url("<?= PATH . TEMPLATE ?>assets/img/header-2-min.jpg") center center/cover no-repeat fixed;'>

		<div class="container">

			<div class="row">

				<div class="col-4">
					<a href="<?= $this->alias() ?>"><img src="<?= $this->img($this->set['img']) ?>" alt="<?= $this->set['name'] ?>" class="img-thumbnail" style="width: 100px; background-color: transparent; border: none"></a>
				</div>

				<nav class="col-8">
					<ul>
						<li><a href="<?= $this->alias() ?>">Главная</a> </li>

						<?php if (!empty($this->menu['information'])) : ?>

							<?php foreach ($this->menu['information'] as $item) : ?>

								<li><a href="<?= $this->alias(['information' => $item['alias']]) ?>"><?= $item['name'] ?></a></li>

							<?php endforeach; ?>

						<?php endif; ?>

						<li><a href="<?= $this->alias('category') ?>">Статьи</a> </li>

						<!-- <li>
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

						</li> -->
					</ul>
				</nav>

			</div>

		</div>
	</header>

	<main class="main">