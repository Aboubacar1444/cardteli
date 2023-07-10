<?php

namespace App\Entity;

use App\Repository\NumerosUssdRelationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NumerosUssdRelationsRepository::class)]
class NumerosUssdRelations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?NumerosUssd $numero = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Espaces $espaces = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNumero(): ?NumerosUssd
    {
        return $this->numero;
    }

    public function setNumero(?NumerosUssd $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getEspaces(): ?Espaces
    {
        return $this->espaces;
    }

    public function setEspaces(Espaces $espaces): self
    {
        $this->espaces = $espaces;

        return $this;
    }
}
