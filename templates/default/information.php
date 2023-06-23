<div class="container" style="padding: 30px 5px 20px 10px">

	<?php if (!empty($this->menu['information'])) : ?>

		<?php foreach ($this->menu['information'] as $item) : ?>

			<?php if ($item['alias'] === ($this->parameters['alias'])) : ?>

				<h1 class="category-page__title"><?= $item['name'] ?></h1>

				<section class="catalog-internal">

					<?= $item['content'] ?>

				</section>

			<?php endif; ?>

		<?php endforeach; ?>

	<?php endif; ?>
</div>