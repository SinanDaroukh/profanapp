<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchRepository")
 */
class Search
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recherche;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecherche(): ?string
    {
        return $this->recherche;
    }

    /**
     * @param mixed $recherche
     */
    public function setRecherche($recherche): void
    {
        $this->recherche = $recherche;
    }
}
