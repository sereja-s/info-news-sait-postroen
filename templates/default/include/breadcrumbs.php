<section class="breadcrumbps">
	<div class="container">
		<div class="breadcrumbps__wrapper">
			<!-- все ссылки а сама страница обычным текстом  -->
			<a href="<?= $this->alias() ?>">Главная</a> <span>/</span>
			<a href="<?= $this->alias('catalog') ?>">Каталог</a> <span>/</span>
			<!-- <a href="#">Крупная бытовая техника</a> <span>/</span> -->
			<span><?= $data['name'] ?></span>
		</div>
	</div>
</section>