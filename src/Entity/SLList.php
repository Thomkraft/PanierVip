<?php

namespace App\Entity;

use App\Repository\SLListRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SLListRepository::class)]
class SLList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
