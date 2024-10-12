<?php

declare(strict_types=1);

use App\Middleware\JsonMiddleware;

return [
    'http' => [
        JsonMiddleware::class,
    ],
];
