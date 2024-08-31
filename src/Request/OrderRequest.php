<?php

declare(strict_types=1);

namespace App\Request;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class OrderRequest
{
    #[Assert\NotBlank(message: 'Usuario não enviado')]
    public int $customer;

    /** @var array<int, Collection<string, string|float>> */
    #[Assert\All(
        new Assert\Collection(
            fields: []
        )
    )]
    public array $additionals;

    /** @var Collection<int, int> */
    #[Assert\All([new Assert\NotBlank(), new Assert\Positive()])]
    public Collection $products;
}
