<!-- FORM -->
<div class="container reg_form">
	<form action="reg.php" method="post" class="row justify-content-center">
		<h2>Форма регистрации</h2>
		<div class="mb-3 col-12 col-md-4 err">

			<?php if (!empty($errMsg)) : ?>
				<?php foreach ($errMsg as $k => $v) : ?>
					<p><?= $errMsg[$k] ?></p>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="msgok">
				<?php if (!empty($msgOk)) : ?>
					<p><?= $msgOk ?></p>
				<?php endif; ?>
			</div>

		</div>

		<div class="w-100"></div>
		<div class="mb-3 col-12 col-md-4">
			<label for="formGroupExampleInput" class="form-label">Ваш логин</label>
			<input name="login" value="<?= $login ?>" type="text" class="form-control" id="formGroupExampleInput" placeholder="введите ваш логин...">
		</div>
		<div class="w-100"></div>
		<div class="mb-3 col-12 col-md-4">
			<label for="exampleInputEmail1" class="form-label">Email</label>
			<input name="mail" value="<?= $email ?>" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="введите ваш email...">
			<div id="emailHelp" class="form-text">Ваш email адрес не будет использован для спама!</div>
		</div>
		<div class="w-100"></div>
		<div class="mb-3 col-12 col-md-4">
			<label for="exampleInputPassword1" class="form-label">Пароль</label>
			<input name="pass-first" type="password" class="form-control" id="exampleInputPassword1" placeholder="введите ваш пароль...">
		</div>
		<div class="w-100"></div>
		<div class="mb-3 col-12 col-md-4">
			<label for="exampleInputPassword2" class="form-label">Повторите пароль</label>
			<input name="pass-second" type="password" class="form-control" id="exampleInputPassword2" placeholder="повторите ваш пароль...">
		</div>
		<div class="w-100"></div>
		<div class="mb-3 col-12 col-md-4">
			<button type="submit" class="btn btn-secondary" name="button-reg">Регистрация</button>
			<a href="#">Войти</a>
		</div>
	</form>
</div>
<!-- END FORM -->