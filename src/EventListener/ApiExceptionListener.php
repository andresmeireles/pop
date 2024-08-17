<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Contracts\ApiResponseExceptionInterface;
use App\Contracts\LogExceptionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class ApiExceptionListener
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    #[AsEventListener(event: KernelEvents::EXCEPTION)]
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof LogExceptionInterface) {
            $this->logger->error($exception->getMessage(), [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }

        if ($exception instanceof ApiResponseExceptionInterface) {
            $response = new JsonResponse(
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );

            $event->setResponse($response);
        }
    }
}
