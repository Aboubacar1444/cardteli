<?php

namespace App\Entity;

use App\Repository\PacksAvantagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PacksAvantagesRepository::class)]
class PacksAvantages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $libelles = null;

    #[ORM\Column]
    private ?int $unites = null;

    #[ORM\Column]
    private ?bool $promos = null;

    #[ORM\Column]
    private ?int $bonus = null;

    #[ORM\ManyToOne(inversedBy: 'packsAvantages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Packs $packs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelles(): ?string
    {
        return $this->libelles;
    }

    public function setLibelles(string $libelles): self
    {
        $this->libelles = $libelles;

        return $this;
    }

    public function getUnites(): ?int
    {
        return $this->unites;
    }

    public function setUnites(int $unites): self
    {
        $this->unites = $unites;

        return $this;
    }

    public function isPromos(): ?bool
    {
        return $this->promos;
    }

    public function setPromos(bool $promos): self
    {
        $this->promos = $promos;

        return $this;
    }

    public function getBonus(): ?int
    {
        return $this->bonus;
    }

    public function setBonus(int $bonus): self
    {
        $this->bonus = $bonus;

        return $this;
    }

    public function getPacks(): ?Packs
    {
        return $this->packs;
    }

    public function setPacks(?Packs $packs): self
    {
        $this->packs = $packs;

        return $this;
    }
}
