<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SupportRepository")
 * @Vich\Uploadable()
 */
class Support
{
    const GRAMMAGE = [
        80, 90, 100, 110, 135, 170, 175, 250, 300, 350, 'aucun'
    ];

    const TYPE = [
        'offset', 'couché', 'bouffant', 'journal', 'autre'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var  File|null
     * @Assert\Image(
     *     mimeTypes="image/jpeg"
     * )
     * @Vich\UploadableField(mapping="support_image", fileNameProperty="filename")
     */
    private $imagefile;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $barcode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $grammage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTypeAsString(int $type): ?string {
        return self::TYPE[$type];
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getGrammage(): ?int
    {
        return $this->grammage;
    }

    public function getGrammageAsString(int $grammage): ?string {
        return self::GRAMMAGE[$grammage];
    }

    public function setGrammage(?int $grammage): self
    {
        $this->grammage = $grammage;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImagefile(): ?File
    {
        return $this->imagefile;
    }

    /**
     * @param File|null $imagefile
     * @return Support
     * @throws \Exception
     */
    public function setImagefile(?File $imagefile): Support
    {
        $this->imagefile = $imagefile;
        if ($this->imagefile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return Support
     */
    public function setFilename(?string $filename): Support
    {
        $this->filename = $filename;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

}
