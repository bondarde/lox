<?php

date_default_timezone_set('Europe/Berlin');

header('Expires: Fri, 10 Sep 2010 00:13:33 GMT');

$token = die();
$date = date('Y-m-d');
$hash = sha1($token . $date);

if (!isset($_GET['hash']) || $_GET['hash'] !== $hash) {
    echo 'DENIED';

    return;
}

echo date('Y-m-d H:i:s') . ': ';
echo(opcache_reset() ? 'SUCCESS' : 'FAILURE');
