<?php

namespace App\Entity;

use App\Repository\AdditionalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdditionalRepository::class)]
#[ORM\Table(name: 'additionals')]
class Additional
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 2, scale: 0)]
    private ?string $value = null;

    #[ORM\Column]
    private ?bool $addition = null;

    #[ORM\ManyToOne(inversedBy: 'aditionals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order = null;

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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function isAddition(): ?bool
    {
        return $this->addition;
    }

    public function setAddition(bool $addition): static
    {
        $this->addition = $addition;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

        return $this;
    }
}
