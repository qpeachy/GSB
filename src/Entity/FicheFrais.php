<?php

namespace App\Entity;

use App\Repository\FicheFraisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FicheFraisRepository::class)]
class FicheFrais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbrJustificatif = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montantValide = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDerniereModif = null;

    #[ORM\Column(length: 255)]
    private ?string $mois = null;

    #[ORM\ManyToOne(inversedBy: 'ficheFrais')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'ficheFrais', targetEntity: LigneFraisHorsForfait::class, orphanRemoval: true)]
    private Collection $ligneFraisHorsForfait;

    #[ORM\OneToMany(mappedBy: 'ficheFrais', targetEntity: LigneFraisForfaitise::class, orphanRemoval: true)]
    private Collection $LigneFraisForfaitise;

    #[ORM\ManyToOne(inversedBy: 'ficheFrais')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $etat = null;

    public function __construct()
    {
        $this->ligneFraisHorsForfait = new ArrayCollection();
        $this->LigneFraisForfaitise = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrJustificatif(): ?int
    {
        return $this->nbrJustificatif;
    }

    public function setNbrJustificatif(int $nbrJustificatif): self
    {
        $this->nbrJustificatif = $nbrJustificatif;

        return $this;
    }

    public function getMontantValide(): ?string
    {
        return $this->montantValide;
    }

    public function setMontantValide(string $montantValide): self
    {
        $this->montantValide = $montantValide;

        return $this;
    }

    public function getDateDerniereModif(): ?\DateTimeInterface
    {
        return $this->dateDerniereModif;
    }

    public function setDateDerniereModif(\DateTimeInterface $dateDerniereModif): self
    {
        $this->dateDerniereModif = $dateDerniereModif;

        return $this;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): self
    {
        $this->mois = $mois;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, LigneFraisHorsForfait>
     */
    public function getLigneFraisHorsForfait(): Collection
    {
        return $this->ligneFraisHorsForfait;
    }

    public function addLigneFraisHorsForfait(LigneFraisHorsForfait $ligneFraisHorsForfait): self
    {
        if (!$this->ligneFraisHorsForfait->contains($ligneFraisHorsForfait)) {
            $this->ligneFraisHorsForfait->add($ligneFraisHorsForfait);
            $ligneFraisHorsForfait->setFichefrais($this);
        }

        return $this;
    }

    public function removeLigneFraisHorsForfait(LigneFraisHorsForfait $ligneFraisHorsForfait): self
    {
        if ($this->ligneFraisHorsForfait->removeElement($ligneFraisHorsForfait)) {
            // set the owning side to null (unless already changed)
            if ($ligneFraisHorsForfait->getFichefrais() === $this) {
                $ligneFraisHorsForfait->setFichefrais(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LigneFraisForfaitise>
     */
    public function getLigneFraisForfaitise(): Collection
    {
        return $this->LigneFraisForfaitise;
    }

    public function addFicheFrais(LigneFraisForfaitise $ficheFrai): self
    {
        if (!$this->LigneFraisForfaitise->contains($ficheFrai)) {
            $this->LigneFraisForfaitise->add($ficheFrai);
            $ficheFrai->setFicheFrais($this);
        }

        return $this;
    }

    public function removeFicheFrais(LigneFraisForfaitise $ficheFrai): self
    {
        if ($this->LigneFraisForfaitise->removeElement($ficheFrai)) {
            // set the owning side to null (unless already changed)
            if ($ficheFrai->getFicheFrais() === $this) {
                $ficheFrai->setFicheFrais(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
