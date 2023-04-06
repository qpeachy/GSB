<?php

namespace App\Entity;

use App\Repository\TypeFraisForfaitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeFraisForfaitRepository::class)]
class TypeFraisForfait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montant = null;

    #[ORM\OneToMany(mappedBy: 'typeFraisForfait', targetEntity: LigneFraisForfaitise::class, orphanRemoval: true)]
    private Collection $TypeFraisForfait;

    public function __construct()
    {
        $this->TypeFraisForfait = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * @return Collection<int, LigneFraisForfaitise>
     */
    public function getTypeFraisForfait(): Collection
    {
        return $this->TypeFraisForfait;
    }

    public function addTypeFraisForfait(LigneFraisForfaitise $typeFraisForfait): self
    {
        if (!$this->TypeFraisForfait->contains($typeFraisForfait)) {
            $this->TypeFraisForfait->add($typeFraisForfait);
            $typeFraisForfait->setTypeFraisForfait($this);
        }

        return $this;
    }

    public function removeTypeFraisForfait(LigneFraisForfaitise $typeFraisForfait): self
    {
        if ($this->TypeFraisForfait->removeElement($typeFraisForfait)) {
            // set the owning side to null (unless already changed)
            if ($typeFraisForfait->getTypeFraisForfait() === $this) {
                $typeFraisForfait->setTypeFraisForfait(null);
            }
        }

        return $this;
    }


}
