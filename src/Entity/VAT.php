<?php

namespace App\Entity;

use App\Repository\VATRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VATRepository::class)]
#[ORM\Table(name:"VATs")]
class VAT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $VATLabel = null;

    #[ORM\Column]
    private ?float $value = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVATLabel(): ?string
    {
        return $this->VATLabel;
    }

    public function setVATLabel(string $VATLabel): static
    {
        $this->VATLabel = $VATLabel;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;

        return $this;
    }
}
