<?php

// composer autoload
include_once __DIR__ . '/vendor/autoload.php';



$sqlite = new \Libra\Database\Sqlite();
$sqlite->test();