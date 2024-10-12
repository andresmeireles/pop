<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\ExceptionHandler\Handler\WhoopsExceptionHandler;
use Swow\Psr7\Message\ResponsePlusInterface;
use Throwable;
use function Hyperf\Support\env;

class WhoopsDevelopmentException extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponsePlusInterface $response)
    {
        $this->stopPropagation();
        return (new WhoopsExceptionHandler())->handle($throwable, $response);
    }

    public function isValid(Throwable $throwable): bool
    {
        return env('APP_ENV') === 'dev';
    }
}
