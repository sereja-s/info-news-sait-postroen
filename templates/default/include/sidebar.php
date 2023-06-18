<div class="sidebar col-md-3 col-12">

	<div class="section search">
		<h5>Поиск</h5>
		<form action="/" method="post">
			<input type="text" name="search-term" class="text-input" placeholder="Найти...">
		</form>
	</div>


	<div class="section topics">

		<?php if (!empty($this->menu['category'])) : ?>

			<h5>Категории</h5>
			<ul>

				<?php foreach ($this->menu['category'] as $item) : ?>

					<li><a href="<?= $this->alias(['category' => $item['alias']]) ?>"><?= $item['name'] ?></a></li>

				<?php endforeach; ?>

			</ul>

		<?php endif; ?>

	</div>

</div>