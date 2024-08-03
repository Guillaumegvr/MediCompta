<?php

namespace App\Entity;

use App\Repository\ChargesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ChargesRepository::class)]
class Charges
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de la charge est obligatoire")]
    #[Assert\Length(
        min: 2,
        max:255,
        minMessage: "le nom de la charge doit faire au moins deux caractères.",
        maxMessage: "Le nom de la charge ne peut pas excéder 250 caractères",
    )]
    private ?string $libelle = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le montant est obligatoire.")]
    #[Assert\Length(min: 1,
        max: 12,
        minMessage: "Le montant de la charge doit contenir au moins un chiffre ",
        maxMessage: "La montant de la charge ne peut pas excéder 12 chiffres"
    )]
    private ?float $montant = null;

    #[ORM\ManyToOne(inversedBy: 'charges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

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
}
