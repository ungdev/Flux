<?php

$config['site_name']  = 'FluxManager';     //[basic] Nom du portail
$config['baseDir']  = '';       // [basic] Répertoire racine du site
$config['baseUrl']  = 'http://'.$_SERVER['HTTP_HOST'].$config['baseDir']; // [basic] Url de base du site
$config['tplUrl']  = $config['baseUrl'] .'/tpl/default';     // [basic] Template
$config['baseServer']  = '/var/www';      // dossier où est stocké la racine du site
$config['libServer']  = $config['baseServer'] .'/lib';     // [basic] Librairie
$config['tplServer']  = $config['baseServer'] .'/tpl/default';     // [basic] Template

$config['database']['type']  = 'mysql';
$config['database']['host']  = 'localhost';
$config['database']['base']  = 'fluxmanager';
$config['database']['user']  = 'fluxmanager';
$config['database']['pass']  = 'fluxmanagerestcon';

?>
