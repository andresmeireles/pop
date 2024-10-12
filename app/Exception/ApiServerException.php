<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Psr\Http\Message\ResponseInterface;

class ApiServerException extends Exception
{
    /** @return array{message: string, context: array} */
    public function report(): array
    {
        return [
            'message' => $this->getMessage(),
            'context' => [],
        ];
    }

    public function render(ResponseInterface $response): ResponseInterface
    {
        $r = $response->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withStatus(500);

        $r->getBody()->write(
            json_encode([
                'file' => $this->getFile(),
                'line' => $this->getLine(),
                'message' => $this->getMessage(),
            ])
        );

        return $r;
    }
}
