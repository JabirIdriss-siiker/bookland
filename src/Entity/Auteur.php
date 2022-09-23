<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AuteurRepository::class)
 * @UniqueEntity("NomPrenom", message = "Cet écrivain existe déja")
 */
class Auteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomPrenom;

    /**
     * @ORM\Column(type="string", length=1)
     * @Assert\Regex(
     *      pattern = "(M|F)",
     *      match = true,
     *      message = "Renseignez soit M ou F"     
     * )
     */
    private $sexe;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date
     */
    private $DateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationalite;

    /**
     * @ORM\ManyToMany(targetEntity=Livre::class, mappedBy="livreauteur")
     */
    private $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }
    public function __toString() {
        return $this->getNomPrenom();
       }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrenom(): ?string
    {
        return $this->NomPrenom;
    }

    public function setNomPrenom(string $NomPrenom): self
    {
        $this->NomPrenom = $NomPrenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->DateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $DateNaissance): self
    {
        $this->DateNaissance = $DateNaissance;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * @return Collection|Livre[]
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres[] = $livre;
            $livre->addLivreAuteur($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->removeElement($livre)) {
            $livre->removeLivreAuteur($this);
        }

        return $this;
    }
}
