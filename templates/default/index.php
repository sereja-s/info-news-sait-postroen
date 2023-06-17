<!-- блок карусели START-->
<div class="container">
	<div class="row">
		<h1 class="slider-title">Топ публикации</h1>
	</div>

	<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">

		<div class="carousel-indicators">
			<button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
			<button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="1" aria-label="Slide 2"></button>
			<button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="2" aria-label="Slide 3"></button>
			<button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="3" aria-label="Slide 4"></button>
		</div>

		<div class="carousel-inner">

			<a href="#" class="carousel-item active">
				<img src="<?= PATH . TEMPLATE ?>assets/img/image_6.png" class="d-block w-100 myimg" alt="...">
				<div class="carousel-caption d-md-block">
					<p>Some representative placeholder content for the first slide.</p>
				</div>
			</a>
			<a href="#" class="carousel-item">
				<img src="<?= PATH . TEMPLATE ?>assets/img/image_3.png" class="d-block w-100 myimg" alt="...">
				<div class="carousel-caption d-md-block">
					<p>Some representative placeholder </p>
				</div>
			</a>
			<a href="#" class="carousel-item">
				<img src="<?= PATH . TEMPLATE ?>assets/img/image_4.png" class="d-block w-100 myimg" alt="...">
				<div class="carousel-caption d-md-block">
					<p>Some representative placeholder content for the first</p>
				</div>
			</a>
			<a href="#" class="carousel-item">
				<img src="<?= PATH . TEMPLATE ?>assets/img/2.jpg" class="d-block w-100 myimg" alt="...">
				<div class="carousel-caption d-md-block">
					<p>Some representative</p>
				</div>
			</a>

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


<!-- блок карусели END-->

<!-- блок main-->
<div class="container">
	<div class="content row">
		<!-- Main Content -->
		<div class="main-content col-md-9 col-12">
			<h2>Новинки</h2>

			<div class="post row">
				<div class="img col-12 col-md-4">
					<a href="#"><img src="<?= PATH . TEMPLATE ?>assets/img/image_6.png" alt="" class="img-thumbnail myimg-post"></a>
				</div>
				<div class="post-text col-12 col-md-8">
					<h3>
						<a href="#">Создание сайтов в Донецке</a>
					</h3>
					<i class="far fa-user"> Admin</i>
					<i class="far fa-calendar"> 15.06.2023</i>
					<p class="preview-text">
						Создание сайтов увлекательный процесс в котором участвуют как программист, так и заказчик
					</p>
				</div>
			</div>
			<div class="post row">
				<div class="img col-12 col-md-4">
					<a href="#"><img src="<?= PATH . TEMPLATE ?>assets/img/image_4.png" alt="" class="img-thumbnail myimg-post"></a>
				</div>
				<div class="post-text col-12 col-md-8">
					<h3>
						<a href="#">Продвижение сайтов в Донецке</a>
					</h3>
					<i class="far fa-user"> Admin</i>
					<i class="far fa-calendar"> 15.06.2023</i>
					<p class="preview-text">
						Сделать сайт в САЙТ ПОСТРОЕН - отличное решение Это творческий процесс и любимая работа для нас
					</p>
				</div>
			</div>
			<div class="post row">
				<div class="img col-12 col-md-4">
					<a href="#"><img src="<?= PATH . TEMPLATE ?>assets/img/2.jpg" alt="" class="img-thumbnail myimg-post"></a>
				</div>
				<div class="post-text col-12 col-md-8">
					<h3>
						<a href="#">Разработка сайтов в Донецке</a>
					</h3>
					<i class="far fa-user">&nbsp;Admin</i>
					<i class="far fa-calendar">&nbsp;15.06.2023</i>
					<p class="preview-text">
						Разработать сайт означает выбрать дизайн, соответствующий требованиям заказчика, сделать его удобным, быстрым, видимым в интернете
					</p>
				</div>
			</div>

		</div>

		<!-- sidebar Content -->
		<?= $this->sidebar ?>

	</div>

</div>