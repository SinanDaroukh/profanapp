<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MediumRepository")
 */
class Medium
{

    const TYPE = [
        'encre', 'peinture', 'nettoyant', 'autre'
    ];

    const LOCALISATION = [
        'SALLE 1', 'SALLE 2', 'SALLE 3', 'SALLE 4'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $codebarre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $localisation;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodebarre(): ?string
    {
        return $this->codebarre;
    }

    public function setCodebarre(string $codebarre): self
    {
        $this->codebarre = $codebarre;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }


    public function getTypeAsString(int $type): ?string {
        return self::TYPE[$type-1];
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLocalisation(): ?int
    {
        return $this->localisation;
    }

    public function getLocalisationAsString(int $type): ?string {
        return self::LOCALISATION[$type-1];
    }

    public function setLocalisation(int $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

}
