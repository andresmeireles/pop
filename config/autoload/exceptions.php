<?php

declare(strict_types=1);

use App\Exception\Handler\ApiServerExceptionHandler;
use App\Exception\Handler\AppExceptionHandler;
use App\Exception\Handler\WhoopsDevelopmentException;
use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;

return [
    'handler' => [
        /*
         * The last middleware is executed first?
         */
        'http' => [
            HttpExceptionHandler::class,
            ApiServerExceptionHandler::class,
            WhoopsDevelopmentException::class,
            AppExceptionHandler::class,
        ],
    ],
];
