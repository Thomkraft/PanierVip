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

    #[ORM\Column]
    private ?int $nbProducts = null;

    /**
     * @var Collection<int, ListedProduct>
     */
    #[ORM\OneToMany(targetEntity: ListedProduct::class, mappedBy: 'shoppingList', cascade: ['persist', 'remove'])]
    private Collection $listedProducts;

    #[ORM\ManyToOne(inversedBy: 'shoppingLists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\Column(type: 'string', length: 150)]
    private ?string $name = null;


    public function __construct()
    {
        $this->listedProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function calculateNbProducts(): void
    {
        if (!$this->listedProducts->isEmpty()) {
            foreach ($this->listedProducts as $product) {
                $this->nbProducts += $product->getQuantity();
            }
        }
    }

    /**
     * @return Collection<int, ListedProduct>
     */
    public function getListedProducts(): Collection
    {
        return $this->listedProducts;
    }

    public function addListedProduct(ListedProduct $listedProduct): static
    {
        if (!$this->listedProducts->contains($listedProduct)) {
            $this->listedProducts->add($listedProduct);
            $listedProduct->setShoppingList($this);
        }

        return $this;
    }

    public function removeListedProduct(ListedProduct $listedProduct): static
    {
        if ($this->listedProducts->removeElement($listedProduct)) {
            // set the owning side to null (unless already changed)
            if ($listedProduct->getShoppingList() === $this) {
                $listedProduct->setShoppingList(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
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
}
