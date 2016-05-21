<?php foreach (($css??[]) as $value) {
	echo '<link href="'.$conf['web_uri'].'css/'.$value.'.css?'.$conf['version'].'" rel="stylesheet"/>';
}

echo $content;

foreach (($js??[]) as $value) {
	echo '<script src="'.$conf['web_uri'].'js/'.$value.'.js?'.$conf['version'].'"></script>';
}
