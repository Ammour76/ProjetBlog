<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Jeux::class)]
    private Collection $jeuxes;

    public function __construct()
    {
        $this->jeuxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection<int, Jeux>
     */
    public function getJeuxes(): Collection
    {
        return $this->jeuxes;
    }

    public function addJeux(Jeux $jeux): self
    {
        if (!$this->jeuxes->contains($jeux)) {
            $this->jeuxes->add($jeux);
            $jeux->setCategorie($this);
        }

        return $this;
    }

    public function removeJeux(Jeux $jeux): self
    {
        if ($this->jeuxes->removeElement($jeux)) {
            // set the owning side to null (unless already changed)
            if ($jeux->getCategorie() === $this) {
                $jeux->setCategorie(null);
            }
        }

        return $this;
    }
}
