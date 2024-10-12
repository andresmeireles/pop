<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Customer;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller]
class CustomerController extends AbstractController
{
    #[GetMapping(path: '')]
    public function all(): ResponseInterface
    {
        return $this->response->json(Customer::all());
    }

    #[PostMapping(path: '')]
    public function create(): ResponseInterface
    {
        $inputs = $this->request->getParsedBody();
        foreach ($inputs as $input) {
            Customer::create([
                'company_name' => $input['trade_name'],
                'trade_name' => $input['company_name'],
                'cnpj' => $input['cnpj'],
                'email' => $input['email'],
                'state' => $input['state'],
                'city' => $input['city'],
            ]);
        }

        return $this->response->json(['message' => count($inputs) . ' added']);
    }
}
