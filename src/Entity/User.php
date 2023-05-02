<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private $created_at;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Jeu::class)]
    private Collection $jeus;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    // #[ORM\OneToMany(mappedBy: 'user', targetEntity: Jeux::class)]
    // private Collection $jeuxes;

    // #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commentaires::class)]
    // private Collection $commentaires;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        // $this->jeuxes = new ArrayCollection();
        // $this->commentaires = new ArrayCollection();  
        $this->jeus = new ArrayCollection();
        $this->comments = new ArrayCollection();

    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    // /**
    //  * @return Collection<int, Jeux>
    //  */
    // public function getJeuxes(): Collection
    // {
    //     return $this->jeuxes;
    // }

    // public function addJeux(Jeux $jeux): self
    // {
    //     if (!$this->jeuxes->contains($jeux)) {
    //         $this->jeuxes->add($jeux);
    //         $jeux->setUser($this);
    //     }

    //     return $this;
    // }

    // public function removeJeux(Jeux $jeux): self
    // {
    //     if ($this->jeuxes->removeElement($jeux)) {
    //         set the owning side to null (unless already changed)
    //         if ($jeux->getUser() === $this) {
    //             $jeux->setUser(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Commentaires>
    //  */
    // public function getCommentaires(): Collection
    // {
    //     return $this->commentaires;
    // }

    // public function addCommentaire(Commentaires $commentaire): self
    // {
    //     if (!$this->commentaires->contains($commentaire)) {
    //         $this->commentaires->add($commentaire);
    //         $commentaire->setUser($this);
    //     }

    //     return $this;
    // }

    // public function removeCommentaire(Commentaires $commentaire): self
    // {
    //     if ($this->commentaires->removeElement($commentaire)) {
    //         // set the owning side to null (unless already changed)
    //         if ($commentaire->getUser() === $this) {
    //             $commentaire->setUser(null);
    //         }
    //     }

    //     return $this;
    // }

    // public function __toString (){
    //     return $this->email;
    // }

    /**
     * @return Collection<int, Jeu>
     */
    public function getJeus(): Collection
    {
        return $this->jeus;
    }

    public function addJeu(Jeu $jeu): self
    {
        if (!$this->jeus->contains($jeu)) {
            $this->jeus->add($jeu);
            $jeu->setUser($this);
        }

        return $this;
    }

    public function removeJeu(Jeu $jeu): self
    {
        if ($this->jeus->removeElement($jeu)) {
            // set the owning side to null (unless already changed)
            if ($jeu->getUser() === $this) {
                $jeu->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->email;
    }
}
