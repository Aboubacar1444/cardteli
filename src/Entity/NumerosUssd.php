<?php

namespace App\Entity;

use App\Repository\NumerosUssdRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NumerosUssdRepository::class)]
class NumerosUssd
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $numerosType = null;

    #[ORM\Column]
    private ?int $numeros = null;

    #[ORM\Column]
    private ?bool $disponibilites = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumerosType(): ?string
    {
        return $this->numerosType;
    }

    public function setNumerosType(string $numerosType): self
    {
        $this->numerosType = $numerosType;

        return $this;
    }

    public function getNumeros(): ?int
    {
        return $this->numeros;
    }

    public function setNumeros(int $numeros): self
    {
        $this->numeros = $numeros;

        return $this;
    }

    public function isDisponibilites(): ?bool
    {
        return $this->disponibilites;
    }

    public function setDisponibilites(bool $disponibilites): self
    {
        $this->disponibilites = $disponibilites;

        return $this;
    }
}
