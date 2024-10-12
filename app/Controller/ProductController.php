<?php

declare(strict_types=1);

namespace App\Controller;

use App\Action\AddProduct;
use App\Contract\Repository\ProductRepositoryInterface;
use App\Exception\ApiServerException;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix: '/product')]
class ProductController extends AbstractController
{
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    #[GetMapping(path: '')]
    public function all(): ResponseInterface
    {
        return $this->response->json($this->productRepository->all());
    }

    /** @throws ApiServerException */
    #[PostMapping(path: '')]
    public function add(AddProduct $addProduct): ResponseInterface
    {
        $parameters = $this->request->all();
        $product = $addProduct->execute($parameters);

        return $this->response->json($product);
    }

    #[GetMapping(path: '{id:\d+}')]
    public function get(int $id): ResponseInterface
    {
        $product = $this->productRepository->byId($id);
        if ($product === null) {
            return $this->response->json(['message' => 'product not found']);
        }

        return $this->response->json($product);
    }
}
