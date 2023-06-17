</main>

<div class="footer container-fluid">

	<div class="footer-content container">
		<div class="row">
			<div class="footer-section about col-md-4 col-12">
				<h3 class="logo-text"><?= $this->set['name'] ?></h3>
				<p>
					<?= $this->set['short_content'] ?>
				</p>
				<div class="contact">
					<span><a href="tel:<?= preg_replace('/[^+\d]/', '', $this->set['phone']) ?>"><i class="fas fa-phone"></i>&nbsp;<?= $this->set['phone'] ?></a></span>
					<span><a href="mailto:<?= $this->set['email'] ?>"><i class="fas fa-envelope"></i>&nbsp;<?= $this->set['email'] ?></a></span>
				</div>

				<?php if (!empty($this->socials)) : ?>

					<div class="socials-icons">

						<?php foreach ($this->socials as $item) : ?>


							<a href="<?= $this->alias($item['external_alias']) ?>"><img src="<?= $this->img($item['img']) ?>" alt="<?= $item['name'] ?>"></a>


						<?php endforeach; ?>

					</div>

				<?php endif; ?>

			</div>

			<div class="footer-section links col-md-4 col-12">
				<h3>Разделы сайта</h3>
				<br>
				<ul>
					<li><a href="<?= $this->alias() ?>">Главная</a> </li>

					<?php if (!empty($this->menu['information'])) : ?>

						<?php foreach ($this->menu['information'] as $item) : ?>

							<li><a href="<?= $this->alias(['information' => $item['alias']]) ?>"><?= $item['name'] ?></a></li>

						<?php endforeach; ?>

					<?php endif; ?>

					<li><a href="<?= $this->alias('category') ?>">Статьи</a> </li>
				</ul>
			</div>

			<div class="footer-section contact-form col-md-4 col-12">

				<h3>Ваше сообщение</h3>
				<form action="/" method="post">
					<input type="email" name="email" class="text-input contact-input" placeholder="Ваш email...">
					<textarea rows="4" name="message" class="text-input contact-input" placeholder="Текст..."></textarea>
					<button type="submit" class="btn btn-big contact-btn">Отправить</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="footer-footer">
	<div class="footer-bottom"><span>сделано в </span><a href="https://saitpostroen.ru/" style="color: coral;">sait_postroen</a></div>
</div>

<?php $this->getScripts() ?>

<!-- Выпуск №147 -->
<!-- Выпуск №148 | Пользовательская часть | показ уведомлений пользователю -->
<?php if (!empty($_SESSION['res']['answer'])) : ?>

	<div class="wq-message__wrap"><?= $_SESSION['res']['answer'] ?></div>

<?php endif; ?>

<?php unset($_SESSION['res']); ?>

</body>

</html>