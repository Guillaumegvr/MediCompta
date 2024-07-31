<?php

namespace App\Entity;

use App\Repository\RemplacementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RemplacementRepository::class)]
class Remplacement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $beginAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'remplacements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'remplacements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Medecin $medecin = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(
        max: 7,
        maxMessage: "Le montant indiqué ne peux pas dépasser 7 chiffres"
    )]
    private ?float $chiffreRealise = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(
        max: 7,
        maxMessage: "Le montant indiqué ne peux pas dépasser 7 chiffres"
    )]
    private ?float $paiementEffectue = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt): static
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }


    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): static
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getChiffreRealise(): ?float
    {
        return $this->chiffreRealise;
    }

    public function setChiffreRealise(?float $chiffreRealise): static
    {
        $this->chiffreRealise = $chiffreRealise;

        return $this;
    }

    public function getPaiementEffectue(): ?float
    {
        return $this->paiementEffectue;
    }

    public function setPaiementEffectue(?float $paiementEffectue): static
    {
        $this->paiementEffectue = $paiementEffectue;

        return $this;
    }

}
