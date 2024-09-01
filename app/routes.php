<?php

declare(strict_types=1);

use App\Controllers\BlogController;

$router = [
    'GET /' => [BlogController::class, 'index'],
    'GET /post/:slug' => [BlogController::class, 'show'],
];
