<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Produto necessita de um nome')]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank(message: 'Produto necessita de uma cor')]
    #[Assert\Length(min: 3, minMessage: 'Cor necessita ter pelo menos 3 caracteres')]
    #[ORM\Column(length: 255, nullable: false)]
    public ?string $color = null;

    #[Assert\NotBlank(message: 'Tamanho obrigatório')]
    #[ORM\Column(length: 255, nullable: false)]
    public ?string $height = null;

    #[Assert\NotBlank(message: 'Produto necessita de um valor como preço')]
    #[Assert\Positive]
    #[ORM\Column]
    private ?float $originalValue = null;

    /**
     * @var Collection<int, ProductCategory>
     */
    #[ORM\ManyToMany(targetEntity: ProductCategory::class, inversedBy: 'products')]
    private Collection $categories;

    /**
     * @var Collection<int, OrderProduct>
     */
    #[ORM\OneToMany(targetEntity: OrderProduct::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $orderProducts;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOriginalValue(): ?float
    {
        return $this->originalValue;
    }

    public function setOriginalValue(float $originalValue): static
    {
        $this->originalValue = $originalValue;

        return $this;
    }

    /**
     * @return Collection<int, ProductCategory>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(ProductCategory $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(ProductCategory $category): static
    {
        $this->categories->removeElement($category);

        return $this;
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
            $orderProduct->setProduct($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): static
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getProduct() === $this) {
                $orderProduct->setProduct(null);
            }
        }

        return $this;
    }
}
