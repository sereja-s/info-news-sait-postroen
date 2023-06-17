<!-- FORM -->
<div class="container reg-form">
	<form class="row justify-content-center" method="post" action="loginnew.php">
		<h1 class="col-12">Авторизация</h1>
		<div class="mb-3 col-12 col-md-4 err">

			<?php if (!empty($errMsg)) : ?>
				<?php foreach ($errMsg as $k => $v) : ?>
					<p><?= $errMsg[$k] ?></p>
				<?php endforeach; ?>
			<?php endif; ?>

		</div>
		<div class="w-100"></div>
		<div class="mb-3 col-12 col-md-4">
			<label for="formGroupExampleInput" class="form-label">Ваша почта (при регистрации)</label>
			<input name="mail" value="<?= $email ?>" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="введите ваш email...">
		</div>
		<div class="w-100"></div>
		<div class="mb-3 col-12 col-md-4">
			<label for="exampleInputPassword1" class="form-label">Пароль</label>
			<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="введите ваш пароль...">
		</div>
		<div class="w-100"></div>
		<div class="mb-3 col-12 col-md-4">
			<button type="submit" name="button-log" class="btn btn-secondary">Войти</button>

			<a href="#"><span style="font-weight: 900;">Регистрация</span></a>
		</div>
	</form>
</div>
<!-- END FORM -->