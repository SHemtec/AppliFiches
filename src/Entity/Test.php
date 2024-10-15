<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\ManyToOne(inversedBy: 'Test')]
    private ?Intervention $intervention = null;

    /**
     * @var Collection<int, TestCapture>
     */
    #[ORM\OneToMany(targetEntity: TestCapture::class, mappedBy: 'test')]
    private Collection $Capture;

    public function __construct()
    {
        $this->Capture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

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

    /**
     * @return Collection<int, TestCapture>
     */
    public function getCapture(): Collection
    {
        return $this->Capture;
    }

    public function addCapture(TestCapture $capture): static
    {
        if (!$this->Capture->contains($capture)) {
            $this->Capture->add($capture);
            $capture->setTest($this);
        }

        return $this;
    }

    public function removeCapture(TestCapture $capture): static
    {
        if ($this->Capture->removeElement($capture)) {
            // set the owning side to null (unless already changed)
            if ($capture->getTest() === $this) {
                $capture->setTest(null);
            }
        }

        return $this;
    }
}
