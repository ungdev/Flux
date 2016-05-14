<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo $NomPage; ?> | FluxManager</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
