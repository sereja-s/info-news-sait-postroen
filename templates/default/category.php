<!-- блок карусели START-->
<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
	<span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
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
			<h2>Статьи с раздела <strong></strong></h2>
			<?php foreach ($posts as $post) : ?>
				<div class="post row">
					<div class="img col-12 col-md-4">
						<img src="" alt="" class="img-thumbnail">
					</div>
					<div class="post_text col-12 col-md-8">
						<h3>
							<a href="#"><?= substr($post['title'], 0, 80) . '...'  ?></a>
						</h3>
						<i class="far fa-user"> <?= $post['username']; ?></i>
						<i class="far fa-calendar"> <?= $post['created_date']; ?></i>
						<p class="preview-text">

							<?= mb_substr($post['content'], 0, 55, 'UTF-8') . '...'  ?>
						</p>
					</div>
				</div>
			<?php endforeach; ?>

		</div>
		<!-- sidebar Content -->
		<div class="sidebar col-md-3 col-12">

			<div class="section search">
				<h3>Поиск</h3>
				<form action="search.php" method="post">
					<input type="text" name="search-term" class="text-input" placeholder="Введите искомое слово...">
				</form>
			</div>


			<div class="section topics">
				<h3>Категории</h3>
				<ul>
					<?php foreach ($topics as $key => $topic) : ?>
						<li>
							<a href="#"><?= $topic['name']; ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

		</div>
	</div>
</div>