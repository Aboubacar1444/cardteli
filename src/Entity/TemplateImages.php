<?php

namespace App\Entity;

use App\Repository\TemplateImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemplateImagesRepository::class)]
class TemplateImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'templateImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TemplatesCarteVisites $modeles = null;

    #[ORM\Column(length: 255)]
    private ?string $images = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModeles(): ?TemplatesCarteVisites
    {
        return $this->modeles;
    }

    public function setModeles(?TemplatesCarteVisites $modeles): self
    {
        $this->modeles = $modeles;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(string $images): self
    {
        $this->images = $images;

        return $this;
    }
}