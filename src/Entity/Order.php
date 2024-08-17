<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`orders`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, OrderProduct>
     */
    #[ORM\OneToMany(targetEntity: OrderProduct::class, mappedBy: 'order_id', orphanRemoval: true)]
    private Collection $orderProducts;

    /**
     * @var Collection<int, Additional>
     */
    #[ORM\OneToMany(targetEntity: Additional::class, mappedBy: 'order_id', orphanRemoval: true)]
    private Collection $additionals;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
        $this->additionals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): static
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts->add($orderProduct);
            $orderProduct->setOrder($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): static
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getOrder() === $this) {
                $orderProduct->setOrder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Additional>
     */
    public function getAdditionals(): Collection
    {
        return $this->additionals;
    }

    public function addAditional(Additional $aditional): static
    {
        if (!$this->additionals->contains($aditional)) {
            $this->additionals->add($aditional);
            $aditional->setOrder($this);
        }

        return $this;
    }

    public function removeAditional(Additional $aditional): static
    {
        if ($this->additionals->removeElement($aditional)) {
            // set the owning side to null (unless already changed)
            if ($aditional->getOrder() === $this) {
                $aditional->setOrder(null);
            }
        }

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }
}
