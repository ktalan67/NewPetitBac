<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultatMancheRepository")
 */
class ResultatManche
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="resultatManches")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Manche", inversedBy="resultatManches")
     */
    private $manche;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->manche = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
        }

        return $this;
    }

    /**
     * @return Collection|Manche[]
     */
    public function getManche(): Collection
    {
        return $this->manche;
    }

    public function addManche(Manche $manche): self
    {
        if (!$this->manche->contains($manche)) {
            $this->manche[] = $manche;
        }

        return $this;
    }

    public function removeManche(Manche $manche): self
    {
        if ($this->manche->contains($manche)) {
            $this->manche->removeElement($manche);
        }

        return $this;
    }
}
