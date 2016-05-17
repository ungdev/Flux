<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?= ($title??'').' - ' . $conf['app_name'] ?></title>
		<link href="<?= $conf['web_uri'] ?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= $conf['web_uri'] ?>css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="<?= $conf['web_uri'] ?>css/style.css" rel="stylesheet">

		<?php foreach (($css??[]) as $value): ?>
			<link href="<?= $conf['web_uri'].'css/'.$value.'.css' ?>" rel="stylesheet"/>
		<?php endforeach; ?>


	</head>
	<body>
		<?= $content ?>

		<script src="<?= $conf['web_uri'] ?>js/jquery.min.js"></script>
		<script src="<?= $conf['web_uri'] ?>js/bootstrap.min.js"></script>
		<?php foreach (($js??[]) as $value): ?>
			<script src="<?= $conf['web_uri'].'js/'.$value.'.js' ?>"></script>
		<?php endforeach; ?>
	</body>
</html>
