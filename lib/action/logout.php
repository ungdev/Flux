<?php

unset($_SESSION);
session_regenerate_id();
session_destroy();

header('Location: '.$config['baseDir'].'/');
