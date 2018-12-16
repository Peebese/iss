<?php

$config = __DIR__ . '/../Commands/config/config.php';
$appConfig = __DIR__ . '/../Commands/config/config.php.dist';

if (!file_exists($config)) {
    copy($appConfig,$config);
}
