<?php

namespace App\Entity;

use App\Repository\EspacesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspacesRepository::class)]
class Espaces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $noms = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreations = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEcheance = null;

    #[ORM\Column]
    private ?int $unitesUssd = 0;

    #[ORM\Column]
    private ?bool $statut = true;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Commandes $commandes = null;

    #[ORM\ManyToOne(inversedBy: 'espaces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\ManyToOne(inversedBy: 'espaces')]
    private ?TemplatesCarteVisites $cardTemplate = null;

    #[ORM\OneToOne( inversedBy: 'espaces', cascade: ['persist', 'remove'])]
    private ?SiteTemplate $siteTemplate = null;

    #[ORM\Column(nullable: true)]
    private ?array $userInfoSiteTemplate = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoms(): ?string
    {
        return $this->noms;
    }

    public function setNoms(string $noms): self
    {
        $this->noms = $noms;

        return $this;
    }

    public function getDateCreations(): ?\DateTimeInterface
    {
        return $this->dateCreations;
    }

    public function setDateCreations(\DateTimeInterface $dateCreations): self
    {
        $this->dateCreations = $dateCreations;

        return $this;
    }

    public function getDateEcheance(): ?\DateTimeInterface
    {
        return $this->dateEcheance;
    }

    public function setDateEcheance(\DateTimeInterface $dateEcheance): self
    {
        $this->dateEcheance = $dateEcheance;

        return $this;
    }

    public function getUnitesUssd(): ?int
    {
        return $this->unitesUssd;
    }

    public function setUnitesUssd(int $unitesUssd): self
    {
        $this->unitesUssd = $unitesUssd;

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

    public function getCommandes(): ?Commandes
    {
        return $this->commandes;
    }

    public function setCommandes(?Commandes $commandes): self
    {
        $this->commandes = $commandes;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getCardTemplate(): ?TemplatesCarteVisites
    {
        return $this->cardTemplate;
    }

    public function setCardTemplate(?TemplatesCarteVisites $cardTemplate): self
    {
        $this->cardTemplate = $cardTemplate;

        return $this;
    }

    public function getSiteTemplate(): ?siteTemplate
    {
        return $this->siteTemplate;
    }

    public function setSiteTemplate(?siteTemplate $siteTemplate): static
    {
        $this->siteTemplate = $siteTemplate;

        return $this;
    }

    public function getUserInfoSiteTemplate(): ?array
    {
        return $this->userInfoSiteTemplate;
    }

    public function setUserInfoSiteTemplate(?array $userInfoSiteTemplate): static
    {
        $this->userInfoSiteTemplate = $userInfoSiteTemplate;

        return $this;
    }
}
