<?php if (!empty($data)) : ?>

	<!-- блок main-->
	<div class="container">

		<div class="content row">
			<!-- Main Content -->
			<div class="main-content col-md-9 col-12">

				<h2><?= $data['name'] ?></h2>

				<div class="single-post row">
					<div class="img col-12">
						<a href="#"><img src="<?= $this->img($data['img']) ?>" alt="<?= $data['name'] ?>" class="img-thumbnail"></a>
					</div>
					<div class="single-post-text col-12">
						<i class=" far fa-user">&nbsp;<?= $data['author'] ?></i>
						<i class="far fa-calendar">&nbsp;<?= $data['date'] ?></i>
						<p>
							<?= $data['content'] ?>
						</p>
					</div>
				</div>

			</div>

			<!-- sidebar Content -->
			<?= $this->sidebar ?>

		</div>

	</div>

<?php endif; ?>