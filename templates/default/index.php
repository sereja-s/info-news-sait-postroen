<!-- блок карусели START-->

<?php if (!empty($articles['hit'])) : ?>

	<div class="container">
		<div class="row">
			<h1 class="slider-title">Топ статьи</h1>
		</div>

		<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">

			<div class="carousel-indicators">

				<?php foreach ($articles['hit'] as $key => $item) : ?>

					<?php if ($key == 0) : ?>

						<button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="<?= $key ?>" class="active" aria-current="true" aria-label="<?= $item['alias'] ?>"></button>

					<?php else : ?>

						<button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="<?= $key ?>" aria-current="true" aria-label="<?= $item['alias'] ?>"></button>

					<?php endif; ?>

				<?php endforeach; ?>


				<!-- <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
				<button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="1" aria-label="Slide 2"></button>
				<button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="2" aria-label="Slide 3"></button>
				<button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="3" aria-label="Slide 4"></button> -->
			</div>

			<div class="carousel-inner">

				<?php foreach ($articles['hit'] as $key => $item) : ?>

					<?php if ($key == 0) : ?>

						<div class="carousel-item active">

						<?php else : ?>

							<div class="carousel-item">

							<?php endif; ?>

							<a href="<?= $this->alias(['article' => $item['alias']]) ?>"><img src="<?= $this->img($item['img']) ?>" alt="<?= $item['name'] ?>"></a>
							<div class="carousel-caption d-md-block" style="color: #000; font-weight: 900;
  text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;">
								<p><?= $item['name'] ?></p>
							</div>
							</div>

						<?php endforeach; ?>

						<!-- <a href="#" class="carousel-item active">
							<img src="<?= PATH . TEMPLATE ?>assets/img/image_3.png" class="d-block w-100 myimg" alt="...">
							<div class="carousel-caption d-md-block">
								<p>Some representative placeholder </p>
							</div>
						</a> -->

						</div>

						<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Previous</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</button>

			</div>



		</div>

	<?php endif; ?>


	<!-- блок карусели END-->

	<!-- блок main-->
	<div class="container">
		<div class="content row">
			<!-- Main Content -->
			<div class="main-content col-md-9 col-12">
				<h2>Новинки</h2>

				<?php if (!empty($newArticles)) : ?>

					<?php foreach ($newArticles as $item) {

						$this->showGoods($item, [], 'articlesItem');
					} ?>

				<?php endif; ?>

			</div>

			<!-- sidebar Content -->
			<?= $this->sidebar ?>

		</div>

	</div>