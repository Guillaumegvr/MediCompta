<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(min: 2,
        max: 50,
        minMessage: "Le nom doit comporter au minimum 2 caractères.",
        maxMessage: "Le nom ne peut excéder 50 caractères."
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(min: 2,
        max: 50,
        minMessage: "Le prénom doit comporter au moins 2 caractères.",
        maxMessage: "Le prénom ne peut excéder 50 caractères."
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min: 4,
        max: 255,
        minMessage: "L'adresse doit comporter au minimum 4 caractères.",
        maxMessage: "L'adresse ne peut excéder 255 caractères."
    )]
    private ?string $adresse = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(min: 5,
        max: 5,
        minMessage: "Le code postal doit faire 5 caractères",
        maxMessage: "Le code postal doit faire 5 caractères"
    )]
    private ?int $codePostal = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(min: 3,
        max: 50,
        minMessage: "La ville  doit faire au moins 3 caractères",
        maxMessage: "La ville ne doit pas faire plus de 50 caractères"
    )]
    #[Assert\Positive]
    private ?string $ville = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(min: 4,
        max: 50,
        minMessage: "Le mail doit comporter au minimum 4 caractères.",
        maxMessage: "Le mail ne peut excéder 50 caractères."
    )]
    #[Assert\Email(
        message: 'l\'email {{ value }} n\'est pas valide.',
    )]
    private ?string $adresseMail = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(min: 10,
        max: 10,
        minMessage: "Le numéro de téléphone doit être composé de 10 chiffres",
        maxMessage:  "Le numéro de téléphone doit être composé de 10 chiffres"
    )]
    private ?int $numeroTel = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(min: 2,
        max: 50,
        minMessage: "Le logiciel doit comporter au minimum 2 caractères.",
        maxMessage: "Le logiciel ne peut excéder 50 caractères."
    )]
    private ?string $logiciel = null;

    #[ORM\Column(nullable: true)]
    private ?bool $secretaire = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    /**
     * @var Collection<int, Remplacement>
     */
    #[ORM\OneToMany(targetEntity: Remplacement::class, mappedBy: 'medecin')]
    private Collection $remplacements;

    public function __construct()
    {
        $this->remplacements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(?int $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresseMail(): ?string
    {
        return $this->adresseMail;
    }

    public function setAdresseMail(?string $adresseMail): static
    {
        $this->adresseMail = $adresseMail;

        return $this;
    }

    public function getNumeroTel(): ?int
    {
        return $this->numeroTel;
    }

    public function setNumeroTel(?int $numeroTel): static
    {
        $this->numeroTel = $numeroTel;

        return $this;
    }

    public function getLogiciel(): ?string
    {
        return $this->logiciel;
    }

    public function setLogiciel(?string $logiciel): static
    {
        $this->logiciel = $logiciel;

        return $this;
    }

    public function isSecretaire(): ?bool
    {
        return $this->secretaire;
    }

    public function setSecretaire(?bool $secretaire): static
    {
        $this->secretaire = $secretaire;

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

    /**
     * @return Collection<int, Remplacement>
     */
    public function getRemplacements(): Collection
    {
        return $this->remplacements;
    }

    public function addRemplacement(Remplacement $remplacement): static
    {
        if (!$this->remplacements->contains($remplacement)) {
            $this->remplacements->add($remplacement);
            $remplacement->setMedecin($this);
        }

        return $this;
    }

    public function removeRemplacement(Remplacement $remplacement): static
    {
        if ($this->remplacements->removeElement($remplacement)) {
            // set the owning side to null (unless already changed)
            if ($remplacement->getMedecin() === $this) {
                $remplacement->setMedecin(null);
            }
        }

        return $this;
    }

}
