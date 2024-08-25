<?php

declare(strict_types=1);

namespace App\Controller;

use App\Contracts\Repository\CustomerRepositoryInterface;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CustomerController extends AbstractController
{
    #[Route('/customer', methods: [Request::METHOD_GET])]
    public function index(CustomerRepository $customerRepository): JsonResponse
    {
        return $this->json([
            'customers' => $customerRepository->findAll(),
        ]);
    }

    #[
        Route(
            '/customer',
            name: 'customer_create',
            methods: ['POST'],
            format: 'json'
        )
    ]
    public function create(
        #[MapRequestPayload] Customer $customer,
        CustomerRepositoryInterface $customerRepository,
    ): Response {
        $newCustomer = $customerRepository->create($customer);

        return $this->json(['message' => sprintf('cliente %s criado com sucesso', $newCustomer->getTradeName())]);
    }
}
