<?php
namespace App\Entity;

class SupportSearch {

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $barcode;

    private $localisation;

    /**
     * @var int|null
     */
    private $grammage;

    /**
     * @var int|null
     */
    private $type;


    private $quantity;
    /**
     * @return string|int
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param string|null $barcode
     * @return SupportSearch
     */
    public function setBarcode(?string $barcode): SupportSearch
    {
        $this->barcode = $barcode;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGrammage(): ?int
    {
        return $this->grammage;
    }

    /**
     * @param int|null $grammage
     * @return SupportSearch
     */
    public function setGrammage(?int $grammage): SupportSearch
    {
        $this->grammage = $grammage;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int|null $type
     * @return SupportSearch
     */
    public function setType(?int $type): SupportSearch
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return SupportSearch
     */
    public function setName(?string $name): SupportSearch
    {
        $this->name = $name;
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
     */
    public function setLocalisation($localisation): void
    {
        $this->localisation = $localisation;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }
}