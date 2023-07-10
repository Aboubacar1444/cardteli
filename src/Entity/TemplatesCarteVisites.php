<?php

namespace App\Entity;

use App\Repository\TemplatesCarteVisitesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemplatesCarteVisitesRepository::class)]
class TemplatesCarteVisites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $titres = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptions = null;

    #[ORM\Column]
    private ?bool $visibilites = true;

    #[ORM\Column]
    private ?int $commandes = 0;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateAjout = null;

    #[ORM\OneToMany(mappedBy: 'modeles', targetEntity: TemplateImages::class, orphanRemoval: true)]
    private Collection $templateImages;

    #[ORM\Column(length: 50)]
    private ?string $types = null;

    #[ORM\Column(length: 255)]
    private ?string $photoCouvertures = null;

    #[ORM\Column]
    private ?bool $new = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 30)]
    private ?string $codes = null;

    public function __construct()
    {
        $this->templateImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitres(): ?string
    {
        return $this->titres;
    }

    public function setTitres(string $titres): self
    {
        $this->titres = $titres;

        return $this;
    }

    public function getDescriptions(): ?string
    {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): self
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    public function isVisibilites(): ?bool
    {
        return $this->visibilites;
    }

    public function setVisibilites(bool $visibilites): self
    {
        $this->visibilites = $visibilites;

        return $this;
    }

    public function getCommandes(): ?int
    {
        return $this->commandes;
    }

    public function setCommandes(int $commandes): self
    {
        $this->commandes = $commandes;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }


    /**
     * @return Collection<int, TemplateImages>
     */
    public function getTemplateImages(): Collection
    {
        return $this->templateImages;
    }

    public function addTemplateImage(TemplateImages $templateImage): self
    {
        if (!$this->templateImages->contains($templateImage)) {
            $this->templateImages->add($templateImage);
            $templateImage->setModeles($this);
        }

        return $this;
    }

    public function removeTemplateImage(TemplateImages $templateImage): self
    {
        if ($this->templateImages->removeElement($templateImage)) {
            // set the owning side to null (unless already changed)
            if ($templateImage->getModeles() === $this) {
                $templateImage->setModeles(null);
            }
        }

        return $this;
    }

    public function getTypes(): ?string
    {
        return $this->types;
    }

    public function setTypes(string $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function getPhotoCouvertures(): ?string
    {
        return $this->photoCouvertures;
    }

    public function setPhotoCouvertures(string $photoCouvertures): self
    {
        $this->photoCouvertures = $photoCouvertures;

        return $this;
    }

    public function isNew(): ?bool
    {
        return $this->new;
    }

    public function setNew(bool $new): self
    {
        $this->new = $new;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
}