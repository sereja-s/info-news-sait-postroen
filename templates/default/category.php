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


			</div>

			<!-- sidebar Content -->
			<?= $this->sidebar ?>

		</div>
	</div>

<?php endif; ?>