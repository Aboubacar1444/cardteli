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

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\Column(nullable: true)]
    private ?int $code_qr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $classe = null;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCodeQr(): ?int
    {
        return $this->code_qr;
    }

    public function setCodeQr(?int $code_qr): self
    {
        $this->code_qr = $code_qr;

        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(?string $classe): static
    {
        $this->classe = $classe;

        return $this;
    }
}
