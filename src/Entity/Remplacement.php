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
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'remplacements')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'remplacements')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Medecin $medecin = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(
        max: 7,
        maxMessage: "Le montant indiqué ne peux pas dépasser 7 chiffres"
    )]
    private ?float $chiffreRealiseParRemplacement = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(
        max: 7,
        maxMessage: "Le montant indiqué ne peux pas dépasser 7 chiffres"
    )]
    private ?float $retrocession = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePaiement = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(
        max: 7,
        maxMessage: "Le montant indiqué ne peux pas dépasser 7 chiffres"
    )]
    private ?float $salaireVerse = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

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

    public function getChiffreRealiseParRemplacement(): ?float
    {
        return $this->chiffreRealiseParRemplacement;
    }

    public function setChiffreRealiseParRemplacement(?float $chiffreRealiseParRemplacement): static
    {
        $this->chiffreRealiseParRemplacement = $chiffreRealiseParRemplacement;

        return $this;
    }

    public function getRetrocession(): ?float
    {
        return $this->retrocession;
    }

    public function setRetrocession(?float $retrocession): static
    {
        $this->retrocession = $retrocession;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(?\DateTimeInterface $datePaiement): static
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getSalaireVerse(): ?float
    {
        return $this->salaireVerse;
    }

    public function setSalaireVerse(?float $salaireVerse): static
    {
        $this->salaireVerse = $salaireVerse;

        return $this;
    }

}
