<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3)]
    private ?string $base = null;

    #[ORM\Column]
    private array $rate = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBase(): ?string
    {
        return $this->base;
    }

    public function setBase(string $base): self
    {
        $this->base = $base;

        return $this;
    }

    public function getRate(): array
    {
        return $this->rate;
    }

    public function setRate(array $rate): self
    {
        $this->rate = $rate;

        return $this;
    }
}
