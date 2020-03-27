<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MancheRepository")
 */
class Manche
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
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $temps;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="manches")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="manches")
     */
    private $games;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Question", inversedBy="manches")
     */
    private $questions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ResultatManche", mappedBy="manche")
     */
    private $resultatManches;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Theme", inversedBy="manches")
     */
    private $theme;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feuille", mappedBy="manche")
     */
    private $feuilles;

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


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->questions = new ArrayCollection();
        //$this->resultatManches = new ArrayCollection();
        $this->theme = new ArrayCollection();
        $this->feuilles = new ArrayCollection();
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTemps(): ?int
    {
        return $this->temps;
    }

    public function setTemps(int $temps): self
    {
        $this->temps = $temps;

        return $this;
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
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
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
            $resultatManch->addManche($this);
        }

        return $this;
    }

    public function removeResultatManch(ResultatManche $resultatManch): self
    {
        if ($this->resultatManches->contains($resultatManch)) {
            $this->resultatManches->removeElement($resultatManch);
            $resultatManch->removeManche($this);
        }

        return $this;
    }

    /**
     * @return Collection|Theme[]
     */
    public function getTheme(): Collection
    {
        return $this->theme;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->theme->contains($theme)) {
            $this->theme[] = $theme;
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        if ($this->theme->contains($theme)) {
            $this->theme->removeElement($theme);
        }

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
            $feuille->setManche($this);
        }

        return $this;
    }

    public function removeFeuille(Feuille $feuille): self
    {
        if ($this->feuilles->contains($feuille)) {
            $this->feuilles->removeElement($feuille);
            // set the owning side to null (unless already changed)
            if ($feuille->getManche() === $this) {
                $feuille->setManche(null);
            }
        }

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

}
