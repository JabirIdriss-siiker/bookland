<?php

namespace App\Entity;

class GenreSearch
{

    /**
     * @var Auteur|null
     */
    private $Auteur;
     /**
     * @var livre|null
     */
    private $Livre;

    /**
     * @return Auteur|null
     */
    public function getAuteur(): ?Auteur
    {
        return $this->Auteur;
    }

    /**
     * @param Livre|null $auteur
     */
    public function setAuteur(?Auteur $Auteur): void
    {
        $this->acteur = $Auteur;
    }
    /**
     * @return Livre|null
     */
    
    public function getLivre(): ?Livre
    {
        return $this->Livre;
    }

    /**
     * @param Livre|null $auteur
     */
    public function setLivre(?Livre $Livre): void
    {
        $this->Livre = $Livre;
    }
}