<?php if (!empty($data)) : ?>

	<!-- блок main-->
	<div class="container">
		<div class="content row">
			<!-- Main Content -->
			<div class="main-content col-md-9 col-12">
				<h2><strong><?= $data['name'] ?></strong></h2>

				<?php foreach ($articles as $item) {

					$this->showGoods($item, [], 'articlesItem');
				} ?>

				<?php if (!empty($pages)) : ?>

					<nav aria-label="Page navigation example">

						<ul class="pagination justify-content-center">

							<?php $this->pagination($pages) ?>

						</ul>

					</nav>

				<?php endif; ?>

			</div>

			<!-- sidebar Content -->
			<?= $this->sidebar ?>

		</div>
	</div>

<?php endif; ?>