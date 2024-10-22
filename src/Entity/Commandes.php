<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Produits = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $orderedAt = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Intervention $intervention = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->status = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduits(): ?string
    {
        return $this->Produits;
    }

    public function setProduits(string $Produits): static
    {
        $this->Produits = $Produits;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getOrderedAt(): ?\DateTimeImmutable
    {
        return $this->orderedAt;
    }

    public function setOrderedAt(?\DateTimeImmutable $orderedAt): static
    {
        $this->orderedAt = $orderedAt;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getIntervention(): ?Intervention
    {
        return $this->intervention;
    }

    public function setIntervention(?Intervention $intervention): static
    {
        $this->intervention = $intervention;

        return $this;
    }
}
