<?php

$payload = $POST['payload'] ?? '';
$data = json_decode($payload, true);

if($data['branch'] != 'master') {
  exit;
}

$commit = $data['commit'];
system('git fetch 2>&1');
system('git checkout '.escapeshellarg($commit).' 2>&1');
