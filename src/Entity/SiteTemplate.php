<?php

namespace App\Entity;

use App\Repository\SiteTemplateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteTemplateRepository::class)]
class SiteTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $previewUrl = null;

    #[ORM\Column(nullable: true)]
    private ?array $images = null;

    #[ORM\OneToOne(targetEntity: 'Espaces', mappedBy: 'siteTemplate', cascade: ['persist', 'remove'])]
    private ?Espaces $espaces = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $previewImage = null;

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

    public function getPreviewUrl(): ?string
    {
        return $this->previewUrl;
    }

    public function setPreviewUrl(string $previewUrl): static
    {
        $this->previewUrl = $previewUrl;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getEspaces(): ?Espaces
    {
        return $this->espaces;
    }

    public function setEspaces(?Espaces $espaces): static
    {
        // unset the owning side of the relation if necessary
        if ($espaces === null && $this->espaces !== null) {
            $this->espaces->setSiteTemplate(null);
        }

        // set the owning side of the relation if necessary
        if ($espaces !== null && $espaces->getSiteTemplate() !== $this) {
            $espaces->setSiteTemplate($this);
        }

        $this->espaces = $espaces;

        return $this;
    }

    public function getPreviewImage(): ?string
    {
        return $this->previewImage;
    }

    public function setPreviewImage(?string $previewImage): static
    {
        $this->previewImage = $previewImage;

        return $this;
    }
}
