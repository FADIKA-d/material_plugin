<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
#[ORM\Table(name:"materials")]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $priceBeforeTax = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $priceIncVAT = null;

    #[ORM\ManyToOne(targetEntity: VAT::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?VAT $VAT = null;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPriceBeforeTax(): ?string
    {
        return $this->priceBeforeTax;
    }

    public function setPriceBeforeTax(string $priceBeforeTax): static
    {
        $this->priceBeforeTax = $priceBeforeTax;

        return $this;
    }
    public function getPriceIncVAT(): ?string
    {
        return $this->priceIncVAT;
    }

    public function setPriceIncVAT(string $priceIncVAT): static
    {
        $this->priceIncVAT = $priceIncVAT;

        return $this;
    }

    public function getVAT(): ?VAT
    {
        return $this->VAT;
    }

    public function setVAT(?VAT $VAT): static
    {
        $this->VAT = $VAT;

        return $this;
    }
}
