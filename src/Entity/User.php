<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 64
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $experience;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $meilleur_score;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Manche", mappedBy="users")
     */
    private $manches;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="users")
     */
    private $games;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ResultatManche", mappedBy="user")
     */
    private $resultatManches;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feuille", mappedBy="user")
     */
    private $feuille;

    public function __construct()
    {
        $this->manches = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->resultatManches = new ArrayCollection();
        $this->feuille = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(?int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getMeilleurScore(): ?int
    {
        return $this->meilleur_score;
    }

    public function setMeilleurScore(?int $meilleur_score): self
    {
        $this->meilleur_score = $meilleur_score;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Manche[]
     */
    public function getManches(): Collection
    {
        return $this->manches;
    }

    public function addManch(Manche $manch): self
    {
        if (!$this->manches->contains($manch)) {
            $this->manches[] = $manch;
            $manch->addUser($this);
        }

        return $this;
    }

    public function removeManch(Manche $manch): self
    {
        if ($this->manches->contains($manch)) {
            $this->manches->removeElement($manch);
            $manch->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->addUser($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            $game->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|ResultatManche[]
     */
    public function getResultatManches(): Collection
    {
        return $this->resultatManches;
    }

    public function addResultatManch(ResultatManche $resultatManch): self
    {
        if (!$this->resultatManches->contains($resultatManch)) {
            $this->resultatManches[] = $resultatManch;
            $resultatManch->addUser($this);
        }

        return $this;
    }

    public function removeResultatManch(ResultatManche $resultatManch): self
    {
        if ($this->resultatManches->contains($resultatManch)) {
            $this->resultatManches->removeElement($resultatManch);
            $resultatManch->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Feuille[]
     */
    public function getFeuille(): Collection
    {
        return $this->feuille;
    }

    public function addFeuille(Feuille $feuille): self
    {
        if (!$this->feuille->contains($feuille)) {
            $this->feuille[] = $feuille;
            $feuille->setUser($this);
        }

        return $this;
    }

    public function removeFeuille(Feuille $feuille): self
    {
        if ($this->feuille->contains($feuille)) {
            $this->feuille->removeElement($feuille);
            // set the owning side to null (unless already changed)
            if ($feuille->getUser() === $this) {
                $feuille->setUser(null);
            }
        }

        return $this;
    }

}
