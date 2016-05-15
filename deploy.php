<?php

$token = $_GET['token'] ?? '';

if ($token === 'Sathahma6nachaHieCiegeim7eelai5eeShot9ai') {
  $data = json_decode($_POST['payload'], true);
  if($data['branch'] != 'master')
  	exit;
  $commit = $data['commit'];
  system('git fetch 2>&1');
  system('git checkout '.escapeshellarg($commit).' 2>&1');
} else {
  header('HTTP/1.0 403 Forbidden');
  die('Access forbidden');
}
