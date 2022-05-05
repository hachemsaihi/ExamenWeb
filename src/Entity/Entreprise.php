<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'SendingPFE', targetEntity: PFE::class, orphanRemoval: true)]
    private $SentPFE;

    public function __construct()
    {
        $this->SentPFE = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, PFE>
     */
    public function getSentPFE(): Collection
    {
        return $this->SentPFE;
    }

    public function addSentPFE(PFE $sentPFE): self
    {
        if (!$this->SentPFE->contains($sentPFE)) {
            $this->SentPFE[] = $sentPFE;
            $sentPFE->setSendingPFE($this);
        }

        return $this;
    }

    public function removeSentPFE(PFE $sentPFE): self
    {
        if ($this->SentPFE->removeElement($sentPFE)) {
            // set the owning side to null (unless already changed)
            if ($sentPFE->getSendingPFE() === $this) {
                $sentPFE->setSendingPFE(null);
            }
        }

        return $this;
    }
}
