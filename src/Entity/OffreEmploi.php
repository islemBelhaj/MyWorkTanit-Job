<?php

namespace App\Entity;

use App\Repository\OffreEmploiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreEmploiRepository::class)]
class OffreEmploi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?int $nbrePostVacant = null;

    #[ORM\Column(length: 50)]
    private ?string $remunirationPropose = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionEmploi = null;

    #[ORM\Column]
    private ?int $experience = null;

    #[ORM\ManyToOne(inversedBy: 'offreEmplois')]
    private ?Gouvernorat $gouvernorat = null;

    /**
     * @var Collection<int, Langue>
     */
    #[ORM\ManyToMany(targetEntity: Langue::class, inversedBy: 'offreEmplois')]
    private Collection $langue;

    #[ORM\ManyToOne(inversedBy: 'offreEmplois')]
    private ?TypeEmploi $TypeEmploi = null;

    #[ORM\ManyToOne(inversedBy: 'offreEmplois')]
    private ?NiveauEtude $NiveauEtude = null;

    #[ORM\Column]
    private ?int $statut = null;

    /**
     * @var Collection<int, Candidature>
     */
    #[ORM\OneToMany(targetEntity: Candidature::class, mappedBy: 'offreEmploi')]
    private Collection $candidatures;

    public function __construct()
    {
        $this->langue = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNbrePostVacant(): ?int
    {
        return $this->nbrePostVacant;
    }

    public function setNbrePostVacant(int $nbrePostVacant): static
    {
        $this->nbrePostVacant = $nbrePostVacant;

        return $this;
    }

    public function getRemunirationPropose(): ?string
    {
        return $this->remunirationPropose;
    }

    public function setRemunirationPropose(string $remunirationPropose): static
    {
        $this->remunirationPropose = $remunirationPropose;

        return $this;
    }

    public function getDescriptionEmploi(): ?string
    {
        return $this->descriptionEmploi;
    }

    public function setDescriptionEmploi(string $descriptionEmploi): static
    {
        $this->descriptionEmploi = $descriptionEmploi;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function getGouvernorat(): ?Gouvernorat
    {
        return $this->gouvernorat;
    }

    public function setGouvernorat(?Gouvernorat $gouvernorat): static
    {
        $this->gouvernorat = $gouvernorat;

        return $this;
    }

    /**
     * @return Collection<int, Langue>
     */
    public function getLangue(): Collection
    {
        return $this->langue;
    }

    public function addLangue(Langue $langue): static
    {
        if (!$this->langue->contains($langue)) {
            $this->langue->add($langue);
        }

        return $this;
    }

    public function removeLangue(Langue $langue): static
    {
        $this->langue->removeElement($langue);

        return $this;
    }

    public function getTypeEmploi(): ?TypeEmploi
    {
        return $this->TypeEmploi;
    }

    public function setTypeEmploi(?TypeEmploi $TypeEmploi): static
    {
        $this->TypeEmploi = $TypeEmploi;

        return $this;
    }

    public function getNiveauEtude(): ?NiveauEtude
    {
        return $this->NiveauEtude;
    }

    public function setNiveauEtude(?NiveauEtude $NiveauEtude): static
    {
        $this->NiveauEtude = $NiveauEtude;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, Candidature>
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): static
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures->add($candidature);
            $candidature->setOffreEmploi($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): static
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getOffreEmploi() === $this) {
                $candidature->setOffreEmploi(null);
            }
        }

        return $this;
    }
}
