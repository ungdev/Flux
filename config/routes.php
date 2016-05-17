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

$route['/admin_stock'] = [ 'controller' => 'Admin', 'action' => 'Stock'];
$route['/admin_gestion_problemes'] = [ 'controller' => 'Admin', 'action' => 'ProblemManager'];
$route['/admin_espaces'] = [ 'controller' => 'Admin', 'action' => 'EspaceManager'];
$route['/admin_utilisateurs'] = [ 'controller' => 'Admin', 'action' => 'UserManager'];

$route['/admin_iframe_log'] = [ 'controller' => 'Admin', 'action' => 'Log'];
$route['/admin_iframe_matrice'] = [ 'controller' => 'Admin', 'action' => 'Matrice'];
$route['/admin_iframe_treso'] = [ 'controller' => 'Admin', 'action' => 'Treso'];

$route['/espace'] = [ 'controller' => 'Espace', 'action' => 'home'];

$route['/espace/json'] = [ 'controller' => 'Espace', 'action' => 'Json'];
$route['/espace/send'] = [ 'controller' => 'Espace', 'action' => 'ChatSend'];
$route['/espace/problem'] = [ 'controller' => 'Espace', 'action' => 'SetProblem'];
$route['/espace/flux'] = [ 'controller' => 'Espace', 'action' => 'SetItem'];

$route['/admin'] = [ 'controller' => 'Admin', 'action' => 'Home'];
$route['/admin/json'] = [ 'controller' => 'Admin', 'action' => 'Json'];
$route['/admin/send'] = [ 'controller' => 'Admin', 'action' => 'ChatSend'];
$route['/admin/problem'] = [ 'controller' => 'Admin', 'action' => 'SetProblem'];
$route['/admin/flux'] = [ 'controller' => 'Admin', 'action' => 'SetItem'];
$route['/admin/progress'] = [ 'controller' => 'Admin', 'action' => 'toggleProgess'];
