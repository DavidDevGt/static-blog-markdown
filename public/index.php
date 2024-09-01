<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/routes.php';

use App\Controllers\BlogController;

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$queryParams = $_GET;

if ($requestUri === '/') {
    (new BlogController())->index();
    exit;
}

if (preg_match('/\/post\/(.+)/', $requestUri, $matches)) {
    (new BlogController())->show($matches[1]);
    exit;
}

// Ruta no encontrada
http_response_code(404);
require __DIR__ . '/../app/Views/error/error404.php';
