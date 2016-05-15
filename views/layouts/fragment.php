<?php foreach (($css??[]) as $value): ?>
	<link href="<?= $conf['web_uri'].'css/'.$value.'.css' ?>" rel="stylesheet"/>
<?php endforeach; ?>

<?= $content ?>

<?php foreach (($js??[]) as $value): ?>
	test
	<script src="<?= $conf['web_uri'].'js/'.$value.'.js' ?>"></script>
<?php endforeach; ?>
