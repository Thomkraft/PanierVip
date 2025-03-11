<?php

namespace App\Entity;

use App\Repository\ShoppingListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShoppingListRepository::class)]
class ShoppingList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $nbProducts = null;

    /**
     * @var Collection<int, Quantity>
     */
    #[ORM\ManyToMany(targetEntity: Quantity::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getNbProducts(): ?int
    {
        return $this->nbProducts;
    }

    public function setNbProducts(int $nbProducts): static
    {
        $this->nbProducts = $nbProducts;

        return $this;
    }

    /**
     * @return Collection<int, Quantity>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Quantity $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    public function removeProduct(Quantity $product): static
    {
        $this->products->removeElement($product);

        return $this;
    }
}
