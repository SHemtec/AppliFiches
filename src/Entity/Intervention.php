<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Intervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Materiel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $MdpSession = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Probleme = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Operations = null;

    #[ORM\Column(nullable: true)]
    private ?float $Cout = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Nettoyage = null;

    #[ORM\ManyToOne(inversedBy: 'Intervention')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    /**
     * @var Collection<int, Test>
     */
    #[ORM\OneToMany(targetEntity: Test::class, mappedBy: 'intervention', cascade: ['persist', 'remove'])]
    private Collection $Test;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $finishedAt = null;

    #[ORM\Column]
    private ?int $statut = null;


    public function __construct()
    {
        $this->Test = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->statut = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMateriel(): ?string
    {
        return $this->Materiel;
    }

    public function setMateriel(string $Materiel): static
    {
        $this->Materiel = $Materiel;

        return $this;
    }

    public function getMdpSession(): ?string
    {
        return $this->MdpSession;
    }

    public function setMdpSession(string $MdpSession): static
    {
        $this->MdpSession = $MdpSession;

        return $this;
    }

    public function getProbleme(): ?string
    {
        return $this->Probleme;
    }

    public function setProbleme(string $Probleme): static
    {
        $this->Probleme = $Probleme;

        return $this;
    }

    public function getOperations(): ?string
    {
        return $this->Operations;
    }

    public function setOperations(?string $Operations): static
    {
        $this->Operations = $Operations;

        return $this;
    }

    public function getCout(): ?float
    {
        return $this->Cout;
    }

    public function setCout(?float $Cout): static
    {
        $this->Cout = $Cout;

        return $this;
    }

    public function isNettoyage(): ?bool
    {
        return $this->Nettoyage;
    }

    public function setNettoyage(?bool $Nettoyage): static
    {
        $this->Nettoyage = $Nettoyage;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Test>
     */
    public function getTest(): Collection
    {
        return $this->Test;
    }

    public function addTest(Test $test): static
    {
        if (!$this->Test->contains($test)) {
            $this->Test->add($test);
            $test->setIntervention($this);
        }

        return $this;
    }

    public function removeTest(Test $test): static
    {
        if ($this->Test->removeElement($test)) {
            // set the owning side to null (unless already changed)
            if ($test->getIntervention() === $this) {
                $test->setIntervention(null);
            }
        }

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeImmutable $finishedAt): static
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, commandes>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(commandes $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setIntervention($this);
        }

        return $this;
    }

    public function removeCommande(commandes $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getIntervention() === $this) {
                $commande->setIntervention(null);
            }
        }

        return $this;
    }
}
