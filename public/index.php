<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// DETECTAR AMBIENTE - PRODUCCIÓN vs LOCAL
if (file_exists(__DIR__ . '/../../repositories/eBooks-A-T/storage/framework/maintenance.php')) {
    // PRODUCCIÓN: /home/userdtemp/repositories/eBooks-A-T/storage/
    require __DIR__ . '/../../repositories/eBooks-A-T/storage/framework/maintenance.php';
} elseif (file_exists(__DIR__ . '/../storage/framework/maintenance.php')) {
    // LOCAL: /tu-proyecto/public/../storage/
    require __DIR__ . '/../storage/framework/maintenance.php';
}

// AUTOLOADER
if (file_exists(__DIR__ . '/../../repositories/eBooks-A-T/vendor/autoload.php')) {
    // PRODUCCIÓN
    require __DIR__ . '/../../repositories/eBooks-A-T/vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    // LOCAL
    require __DIR__ . '/../vendor/autoload.php';
}

// BOOTSTRAP LARAVEL
/** @var Application $app */
if (file_exists(__DIR__ . '/../../repositories/eBooks-A-T/bootstrap/app.php')) {
    // PRODUCCIÓN
    $app = require_once __DIR__ . '/../../repositories/eBooks-A-T/bootstrap/app.php';
} elseif (file_exists(__DIR__ . '/../bootstrap/app.php')) {
    // LOCAL  
    $app = require_once __DIR__ . '/../bootstrap/app.php';
} else {
    die('Error: Laravel bootstrap files not found');
}

$app->handleRequest(Request::capture());
