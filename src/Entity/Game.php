<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="games")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $creator_id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feuille", mappedBy="game")
     */
    private $feuilles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Manche", mappedBy="game")
     */
    private $manches;

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->feuilles = new ArrayCollection();
        $this->manches = new ArrayCollection();
        $this->setState(1); ////1 active (à la création), 2 en cours (manches en cours), 3 terminée (fin de partie).
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCreatorId(): ?int
    {
        return $this->creator_id;
    }

    public function setCreatorId(?int $creator_id): self
    {
        $this->creator_id = $creator_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|Feuille[]
     */
    public function getFeuilles(): Collection
    {
        return $this->feuilles;
    }

    public function addFeuille(Feuille $feuille): self
    {
        if (!$this->feuilles->contains($feuille)) {
            $this->feuilles[] = $feuille;
            $feuille->setGame($this);
        }

        return $this;
    }

    public function removeFeuille(Feuille $feuille): self
    {
        if ($this->feuilles->contains($feuille)) {
            $this->feuilles->removeElement($feuille);
            // set the owning side to null (unless already changed)
            if ($feuille->getGame() === $this) {
                $feuille->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Manche[]
     */
    public function getManches(): Collection
    {
        return $this->manches;
    }

    public function addManche(Manche $manch): self
    {
        if (!$this->manches->contains($manch)) {
            $this->manches[] = $manch;
            $manch->setGame($this);
        }

        return $this;
    }

    public function removeManches(Manche $manche): self
    {
        if ($this->manches->contains($manche)) {
            $this->manches->removeElement($manche);
            // set the owning side to null (unless already changed)
            if ($manche->getGame() === $this) {
                $manche->setGame(null);
            }
        }

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }
}
