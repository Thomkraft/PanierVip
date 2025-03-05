<?php

namespace App\Entity;

use App\Repository\StatisticsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatisticsRepository::class)]
class Statistics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $totalSpent = null;

    #[ORM\Column(nullable: true)]
    private ?float $spentInCategory = null;

    #[ORM\Column(nullable: true)]
    private ?int $userId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalSpent(): ?float
    {
        return $this->totalSpent;
    }

    public function setTotalSpent(?float $totalSpent): static
    {
        $this->totalSpent = $totalSpent;

        return $this;
    }

    public function getSpentInCategory(): ?float
    {
        return $this->spentInCategory;
    }

    public function setSpentInCategory(?float $spentInCategory): static
    {
        $this->spentInCategory = $spentInCategory;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }
}
