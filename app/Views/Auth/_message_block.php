<?php if (session()->has('message')) : ?>
	<div class="alert px-5 alert-success">
		<?= session('message') ?>
	</div>
<?php endif ?>

<?php if (session()->has('error')) : ?>
	<div class="alert px-5 alert-danger">
		<?= session('error') ?>
	</div>
<?php endif ?>

<?php if (session()->has('errors')) : ?>
	<ul class="alert px-5 alert-danger">
		<?php foreach (session('errors') as $error) : ?>
			<li><?= $error ?></li>
		<?php endforeach ?>
	</ul>
<?php endif ?>