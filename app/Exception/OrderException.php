<?php

declare(strict_types=1);

namespace App\Exception;

class OrderException extends ApiServerException
{
    public function __construct(string $message = '', int $code = 0, private readonly array $context = [])
    {
        parent::__construct($message, $code);
    }

    public function report(): array
    {
        return [
            'message' => $this->getMessage() === '' ? 'error when create order' : $this->getMessage(),
            'context' => $this->context,
        ];
    }
}
