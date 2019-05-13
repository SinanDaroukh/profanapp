<?php
namespace App\Entity;

class SupportSearch {

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var int|null
     */
    private $barcode;

    /**
     * @var int|null
     */
    private $grammage;

    /**
     * @var int|null
     */
    private $type;

    /**
     * @return int|null
     */
    public function getBarcode(): ?int
    {
        return $this->barcode;
    }

    /**
     * @param int|null $barcode
     * @return SupportSearch
     */
    public function setBarcode(?int $barcode): SupportSearch
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









}