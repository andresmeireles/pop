<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductCategoryRepository::class)]
#[ORM\Table(name: 'product_categories')]
class ProductCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Categoria necessita de um nome')]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'categories')]
    private Collection $products;

    /**
     * @var Collection<int, Freight>
     */
    #[ORM\OneToMany(targetEntity: Freight::class, mappedBy: 'productCategory', orphanRemoval: true)]
    private Collection $freights;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->freights = new ArrayCollection();
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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            $product->removeCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Freight>
     */
    public function getFreights(): Collection
    {
        return $this->freights;
    }

    public function addFreight(Freight $freight): static
    {
        if (!$this->freights->contains($freight)) {
            $this->freights->add($freight);
            $freight->setProductCategory($this);
        }

        return $this;
    }

    public function removeFreight(Freight $freight): static
    {
        if ($this->freights->removeElement($freight)) {
            // set the owning side to null (unless already changed)
            if ($freight->getProductCategory() === $this) {
                $freight->setProductCategory(null);
            }
        }

        return $this;
    }
}
