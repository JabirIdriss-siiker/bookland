<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 */
class Livre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Isbn(
     *     type = "isbn13",
     *     message = "L'ISBN rentré est invalide."
     * )
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(
     *     value = 0,
     *     message = "Le nombre de pages doit être supérieur à 0"
     * )
     */
    private $nbpages;

    /**
     * @ORM\Column(type="date")
     */
    private $dateParution;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }}.",
     * )
     */
    private $note;

    /**
     * @ORM\ManyToMany(targetEntity=Auteur::class, inversedBy="livres")
     */
    private $livreauteur;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="livres")
     */
    private $livreGenre;

    public function __construct()
    {
        $this->livreauteur = new ArrayCollection();
        $this->livreGenre = new ArrayCollection();
    }

    public function __toString() {
        return $this->getTitre();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNbpages(): ?int
    {
        return $this->nbpages;
    }

    public function setNbpages(int $nbpages): self
    {
        $this->nbpages = $nbpages;

        return $this;
    }

    public function getdateParution(): ?\DateTimeInterface
    {
        return $this->dateParution;
    }

    public function setdateParution(\DateTimeInterface $dateParution): self
    {
        $this->dateParution = $dateParution;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }
    public function setGenre(Genre $genre): self
    {
        $this->livreGenre = $genre;

        return $this;
    }

    /**
     * @return Collection|Auteur[]
     */
    
    public function getLivreAuteur(): Collection
    {
        return $this->livreauteur;
    }

    /**
     * @return Collection|Auteur[]
     */

    public function addLivreAuteur(Auteur $livreAuteur): self
    {
        if (!$this->livreauteur->contains($livreAuteur)) {
            $this->livreauteur[] = $livreAuteur;
        }

        return $this;
    }
    /**
     * @return Collection|Auteur[]
     */
    public function removeLivreAuteur(Auteur $livreAuteur): self
    {
        $this->livreauteur->removeElement($livreAuteur);

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getLivreGenre(): Collection
    {
        return $this->livreGenre;
    }
      /**
     * @return Collection|Genre[]
     */
    public function addLivreGenre(Genre $livreGenre): self
    {
        if (!$this->livreGenre->contains($livreGenre)) {
            $this->livreGenre[] = $livreGenre;
        }

        return $this;
    }

    public function removeLivreGenre(Genre $livreGenre): self
    {
        $this->livreGenre->removeElement($livreGenre);

        return $this;
    }
}
