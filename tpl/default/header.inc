<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $NomPage; ?> | FluxManager</title>
        <meta name="author" content="Xavier Bernard, Florent Poinsaut" />
        <meta name="description" content="Gestionnaire de flux du Gala" />
<?php
// Inclusion des pages de style
foreach($Css as $css)
{ ?>
    <link href='<?php echo $config['tplUrl']; ?>/css/<?php echo $css; ?>.css' rel='stylesheet' type='text/css' />
<?php }
// Inclusion des pages JavaScript
foreach($Js as $js)
{ ?>
    <script type="text/javascript" src="<?php echo $config['baseUrl']; ?>/js/<?php echo $js; ?>.js"></script>
<?php }
?>
  </head>
  <body>
