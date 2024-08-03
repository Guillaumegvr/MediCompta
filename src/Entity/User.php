<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: "Le mail est obligatoire.")]
    #[Assert\Length(min: 4,
        max: 50,
        minMessage: "Le mail doit comporter au minimum 4 caractères.",
        maxMessage: "Le mail ne peut excéder 50 caractères."
    )]
    #[Assert\Email(
        message: 'l\'email {{ value }} n\'est pas valide.',
    )]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

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

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'adresse est obligatoire.")]
    #[Assert\Length(min: 4,
        max: 255,
        minMessage: "L'adresse doit comporter au minimum 4 caractères.",
        maxMessage: "L'adresse ne peut excéder 255 caractères."
    )]
    private ?string $adresse = null;

    #[ORM\Column(length: 5)]
    #[Assert\NotBlank(message: "Le code postal est obligatoire.")]
    #[Assert\Length(min: 5,
        max: 5,
        minMessage: "Le code postal doit faire 5 caractères",
        maxMessage: "Le code postal doit faire 5 caractères"
    )]
    private ?int $codepostal = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "La ville est obligatoire.")]
    #[Assert\Length(min: 3,
        max: 50,
        minMessage: "La ville  doit faire au moins 3 caractères",
        maxMessage: "La ville ne doit pas faire plus de 50 caractères"
    )]
    #[Assert\Positive]
    private ?string $ville = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message: "La date de création est obligatoire.")]
    private ?\DateTimeInterface $dateCreation = null;


    #[ORM\OneToMany(targetEntity: Remplacement::class,  mappedBy: 'user', orphanRemoval: true,)]
    private Collection $remplacements;

    #[ORM\Column]
    private ?int $pourcentageSalaireVerse = null;

    /**
     * @var Collection<int, Charges>
     */
    #[ORM\OneToMany(targetEntity: Charges::class, mappedBy: 'User')]
    private Collection $charges;

    public function __construct()
    {
        $this->remplacements = new ArrayCollection();
        $this->charges = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): static
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

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
            $remplacement->setUser($this);
        }

        return $this;
    }

    public function removeRemplacement(Remplacement $remplacement): static
    {
        if ($this->remplacements->removeElement($remplacement)) {
            // set the owning side to null (unless already changed)
            if ($remplacement->getUser() === $this) {
                $remplacement->setUser(null);
            }
        }

        return $this;
    }

    public function getPourcentageSalaireVerse(): ?int
    {
        return $this->pourcentageSalaireVerse;
    }

    public function setPourcentageSalaireVerse(int $pourcentageSalaireVerse): static
    {
        $this->pourcentageSalaireVerse = $pourcentageSalaireVerse;

        return $this;
    }

    /**
     * @return Collection<int, Charges>
     */
    public function getCharges(): Collection
    {
        return $this->charges;
    }

    public function addCharge(Charges $charge): static
    {
        if (!$this->charges->contains($charge)) {
            $this->charges->add($charge);
            $charge->setUser($this);
        }

        return $this;
    }

    public function removeCharge(Charges $charge): static
    {
        if ($this->charges->removeElement($charge)) {
            // set the owning side to null (unless already changed)
            if ($charge->getUser() === $this) {
                $charge->setUser(null);
            }
        }

        return $this;
    }


}
