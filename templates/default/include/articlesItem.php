<?php if (!empty($data)) : ?>

	<div class="post row">
		<div class="img col-12 col-md-4">
			<a href="<?= $this->alias(['article' => $data['alias']]) ?>"><img src="<?= $this->img($data['img']) ?>" alt="<?= $data['name'] ?>" class="img-thumbnail myimg-post"></a>
		</div>
		<div class="post-text col-12 col-md-8">
			<h3>
				<a href="<?= $this->alias(['article' => $data['alias']]) ?>"><?= $data['name'] ?></a>
			</h3>
			<i class="far fa-user">&nbsp;<?= $data['author'] ?></i>
			<i class="far fa-calendar">&nbsp;<?= $data['date'] ?></i>
			<p class="preview-text">
				<?= $data['short_content'] ?>
			</p>
		</div>
	</div>

<?php endif; ?>