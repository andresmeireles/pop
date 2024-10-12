<?php

declare(strict_types=1);

namespace App\Controller;

class IndexController extends AbstractController
{
    public function index(): array
    {
        $user = $this->request->input('user', 'Andre Meireles');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }
}
