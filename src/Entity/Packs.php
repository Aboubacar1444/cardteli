<?php

namespace App\Entity;

use App\Repository\PacksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PacksRepository::class)]
class Packs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?bool $promos = null;

    #[ORM\Column]
    private ?int $taux = null;

    #[ORM\Column]
    private ?int $montants = null;

    #[ORM\Column(length: 20)]
    private ?string $codes = null;

    #[ORM\OneToMany(mappedBy: 'packs', targetEntity: PacksAvantages::class)]
    private Collection $packsAvantages;

    #[ORM\Column(nullable: true)]
    private ?int $commandes = null;

    public function __construct()
    {
        $this->packsAvantages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getTaux(): ?int
    {
        return $this->taux;
    }

    public function setTaux(int $taux): self
    {
        $this->taux = $taux;

        return $this;
    }

    public function getMontants(): ?int
    {
        return $this->montants;
    }

    public function setMontants(int $montants): self
    {
        $this->montants = $montants;

        return $this;
    }

    public function getCodes(): ?string
    {
        return $this->codes;
    }

    public function setCodes(string $codes): self
    {
        $this->codes = $codes;

        return $this;
    }

    /**
     * @return Collection<int, PacksAvantages>
     */
    public function getPacksAvantages(): Collection
    {
        return $this->packsAvantages;
    }

    public function addPacksAvantage(PacksAvantages $packsAvantage): self
    {
        if (!$this->packsAvantages->contains($packsAvantage)) {
            $this->packsAvantages->add($packsAvantage);
            $packsAvantage->setPacks($this);
        }

        return $this;
    }

    public function removePacksAvantage(PacksAvantages $packsAvantage): self
    {
        if ($this->packsAvantages->removeElement($packsAvantage)) {
            // set the owning side to null (unless already changed)
            if ($packsAvantage->getPacks() === $this) {
                $packsAvantage->setPacks(null);
            }
        }

        return $this;
    }

    public function getCommandes(): ?int
    {
        return $this->commandes;
    }

    public function setCommandes(?int $commandes): self
    {
        $this->commandes = $commandes;

        return $this;
    }
}
