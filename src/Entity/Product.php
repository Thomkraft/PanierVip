<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $weight = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column]
    private ?int $euros = null;

    #[ORM\Column]
    private ?int $centimes = null;

    /**
     * @var Collection<int, Quantity>
     */
    #[ORM\OneToMany(targetEntity: Quantity::class, mappedBy: 'idProduct', orphanRemoval: true)]
    private Collection $quantity;

    public function __construct()
    {
        $this->quantity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isWeight(): ?bool
    {
        return $this->weight;
    }

    public function setWeight(bool $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getEuros(): ?int
    {
        return $this->euros;
    }

    public function setEuros(int $euros): static
    {
        $this->euros = $euros;

        return $this;
    }

    public function getCentimes(): ?int
    {
        return $this->centimes;
    }

    public function setCentimes(int $centimes): static
    {
        $this->centimes = $centimes;

        return $this;
    }

    /**
     * @return Collection<int, Quantity>
     */
    public function getQuantity(): Collection
    {
        return $this->quantity;
    }

    public function addQuantity(Quantity $quantity): static
    {
        if (!$this->quantity->contains($quantity)) {
            $this->quantity->add($quantity);
            $quantity->setIdProduct($this);
        }

        return $this;
    }

    public function removeQuantity(Quantity $quantity): static
    {
        if ($this->quantity->removeElement($quantity)) {
            // set the owning side to null (unless already changed)
            if ($quantity->getIdProduct() === $this) {
                $quantity->setIdProduct(null);
            }
        }

        return $this;
    }
}
