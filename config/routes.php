<?php

/**
 * Route format :
 * baseuri/[route]?getparams
 *
 * This file match route with controller and action
 * $route['route'] = [ 'controller' => 'TestController', 'action' => 'TestAction'];
 */

$route['/'] = [ 'controller' => 'Login', 'action' => 'Login'];
$route['/logout'] = [ 'controller' => 'Login', 'action' => 'Logout'];
$route['/admin'] = [ 'controller' => 'Admin', 'action' => 'Home'];
$route['/admin_administration'] = [ 'controller' => 'Admin', 'action' => 'Administration'];
$route['/admin_stock'] = [ 'controller' => 'Admin', 'action' => 'Stock'];
$route['/admin_gestion_problemes'] = [ 'controller' => 'Admin', 'action' => 'ProblemManager'];
$route['/admin_espaces'] = [ 'controller' => 'Admin', 'action' => 'EspaceManager'];
$route['/admin_utilisateurs'] = [ 'controller' => 'Admin', 'action' => 'UserManager'];

$route['/admin_logistique'] = [ 'controller' => 'Admin', 'action' => 'LogContainer'];
$route['/admin_matrice'] = [ 'controller' => 'Admin', 'action' => 'MatriceContainer'];
$route['/admin_tresorerie'] = [ 'controller' => 'Admin', 'action' => 'TresoContainer'];

$route['/admin_iframe_log'] = [ 'controller' => 'Admin', 'action' => 'Log'];
$route['/admin_iframe_matrice'] = [ 'controller' => 'Admin', 'action' => 'Matrice'];
$route['/admin_iframe_treso'] = [ 'controller' => 'Admin', 'action' => 'Treso'];
$route['/admin_problemes'] = [ 'controller' => 'Admin', 'action' => 'Problem'];

$route['/espace'] = [ 'controller' => 'Espace', 'action' => 'home'];
$route['/chat'] = [ 'controller' => 'Espace', 'action' => 'chat'];

$route['/espace/json'] = [ 'controller' => 'Espace', 'action' => 'Json'];
$route['/espace/send'] = [ 'controller' => 'Espace', 'action' => 'ChatSend'];
$route['/espace/problem'] = [ 'controller' => 'Espace', 'action' => 'SetProblem'];
$route['/espace/flux'] = [ 'controller' => 'Espace', 'action' => 'setItem'];
