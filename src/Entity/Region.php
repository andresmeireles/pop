<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
#[ORM\Table(name: "regions")]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'regions')]
    private ?Seller $seller = null;

    /**
     * @var Collection<int, Freight>
     */
    #[ORM\OneToMany(targetEntity: Freight::class, mappedBy: 'region', orphanRemoval: true)]
    private Collection $freights;

    public function __construct()
    {
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

    public function getSeller(): ?Seller
    {
        return $this->seller;
    }

    public function setSeller(?Seller $seller): static
    {
        $this->seller = $seller;

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
            $freight->setRegion($this);
        }

        return $this;
    }

    public function removeFreight(Freight $freight): static
    {
        if ($this->freights->removeElement($freight)) {
            // set the owning side to null (unless already changed)
            if ($freight->getRegion() === $this) {
                $freight->setRegion(null);
            }
        }

        return $this;
    }
}
