<?php
namespace App\Entity;

class Search {

    /**
     * @var string|null
     */
    private $nom;

    /**
     * @var string|null
     */
    private $codebarre;

    /**
     * @var int|null
     */
    private $localisation;

    /**
     * @var int|null
     */
    private $type;

    /**
     * @var int|null
     */
    private $quantitymax;

    /**
     * @return mixed
     */
    public function getCodebarre()
    {
        return $this->codebarre;
    }

    /**
     * @param mixed $codebarre
     * @return Search
     */
    public function setCodebarre($codebarre)
    {
        $this->codebarre = $codebarre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param mixed $localisation
     * @return Search
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Search
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantitymax()
    {
        return $this->quantitymax;
    }

    /**
     * @param mixed $quantitymax
     * @return Search
     */
    public function setQuantitymax($quantitymax)
    {
        $this->quantitymax = $quantitymax;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom($nom): void
    {
        $this->nom = $nom;
    }
}
