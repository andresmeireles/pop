<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use App\Contract\Bridge\AppLoggerInterface;
use App\Exception\ApiServerException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\Validation\ValidationException;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ApiServerExceptionHandler extends ExceptionHandler
{
    public function __construct(private readonly AppLoggerInterface $logger) {}

    /**
     * @throws JsonException
     */
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        if ($throwable instanceof ApiServerException) {
            $this->stopPropagation();
            $this->logger->error($throwable->report()['message'], $throwable->report()['context']);
            return $throwable->render($response);
        }

        if ($throwable instanceof ValidationException) {
            $this->stopPropagation();
            $response->getBody()->write(
                json_encode(
                    ['message' => $throwable->getMessage()],
                    JSON_THROW_ON_ERROR
                ),
            );

            return $response->withStatus(Response::HTTP_BAD_REQUEST);
        }

        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
