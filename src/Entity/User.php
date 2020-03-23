<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

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

    public function __construct()
    {
        $this->manches = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->resultatManches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
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
}
