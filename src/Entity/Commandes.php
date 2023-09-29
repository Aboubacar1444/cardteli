<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $reference = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCommandes = null;

    #[ORM\Column]
    // Passer commande = 0 (par defaut)
    // Commande traité = 1
    private ?bool $statut = false;

    #[ORM\Column(length: 20)]
    private ?string $modePaiement = null;

    #[ORM\Column]
    private ?int $Total = null;

    #[ORM\Column]
    private ?int $remise = null;

    #[ORM\Column]
    private ?int $totalTcc = null;

    #[ORM\Column]
    private ?bool $promotions = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Espaces $espaces = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $productType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDateCommandes(): ?\DateTimeInterface
    {
        return $this->dateCommandes;
    }

    public function setDateCommandes(\DateTimeInterface $dateCommandes): self
    {
        $this->dateCommandes = $dateCommandes;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(string $modePaiement): self
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->Total;
    }

    public function setTotal(int $Total): self
    {
        $this->Total = $Total;

        return $this;
    }

    public function getRemise(): ?int
    {
        return $this->remise;
    }

    public function setRemise(int $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getTotalTcc(): ?int
    {
        return $this->totalTcc;
    }

    public function setTotalTcc(int $totalTcc): self
    {
        $this->totalTcc = $totalTcc;

        return $this;
    }

    public function isPromotions(): ?bool
    {
        return $this->promotions;
    }

    public function setPromotions(bool $promotions): self
    {
        $this->promotions = $promotions;

        return $this;
    }

    public function getEspaces(): ?Espaces
    {
        return $this->espaces;
    }

    public function setEspaces(?Espaces $espaces): self
    {
        $this->espaces = $espaces;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProductType(): ?string
    {
        return $this->productType;
    }

    public function setProductType(string $productType): self
    {
        $this->productType = $productType;

        return $this;
    }
}
