<?php

namespace App\Entity;

use App\Repository\SpentInCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpentInCategoryRepository::class)]
class SpentInCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $amount = null;

    #[ORM\Column]
    private ?int $isUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getIsUser(): ?int
    {
        return $this->isUser;
    }

    public function setIsUser(int $isUser): static
    {
        $this->isUser = $isUser;

        return $this;
    }
}
