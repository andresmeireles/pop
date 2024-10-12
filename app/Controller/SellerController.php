<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Seller;
use Hyperf\HttpServer\Annotation\Controller;
use Psr\Http\Message\ResponseInterface;

#[Controller]
class SellerController extends AbstractController
{
    public function byId(int $id): ResponseInterface
    {
        $seller = Seller::find($id);
        return $this->response->json($seller);
    }

    public function create(array $seller): ResponseInterface
    {
        $seller = Seller::create($seller);
        return $this->response->json($seller);
    }
}
