<?php

namespace App\Entity;

use App\Repository\LigneFraisForfaitiseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneFraisForfaitiseRepository::class)]
class LigneFraisForfaitise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'ficheFrais')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FicheFrais $ficheFrais = null;

    #[ORM\ManyToOne(inversedBy: 'TypeFraisForfait')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeFraisForfait $typeFraisForfait = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getFicheFrais(): ?FicheFrais
    {
        return $this->ficheFrais;
    }

    public function setFicheFrais(?FicheFrais $ficheFrais): self
    {
        $this->ficheFrais = $ficheFrais;

        return $this;
    }

    public function getTypeFraisForfait(): ?TypeFraisForfait
    {
        return $this->typeFraisForfait;
    }

    public function setTypeFraisForfait(?TypeFraisForfait $typeFraisForfait): self
    {
        $this->typeFraisForfait = $typeFraisForfait;

        return $this;
    }
}
