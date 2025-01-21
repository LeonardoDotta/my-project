<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Verificar se o aplicativo está em manutenção
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Registrar o autoloader do Composer
require __DIR__ . '/../vendor/autoload.php';

// Iniciar o Laravel e manipular a solicitação
(require_once __DIR__ . '/../bootstrap/app.php')
    ->handleRequest(Request::capture());