<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/_item$/",
     *     match=true,
     *     message="Name must end in prefix _item"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(
     *      min = 10,
     *      max = 100,
     *      notInRangeMessage = "Value must be between {{ min }} and {{ max }} to enter.",
     * )
     */
    private $value;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = -10,
     *      max = 50,
     *      notInRangeMessage = "Quality must between {{ min }} and {{ max }} to enter.",
     * )
     */
    private $quality;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="items")
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getQuality(): ?int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
