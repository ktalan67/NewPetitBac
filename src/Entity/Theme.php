<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ThemeRepository")
 */
class Theme
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Question", mappedBy="theme")
     */
    private $questions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Manche", mappedBy="theme")
     */
    private $manches;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->manches = new ArrayCollection();
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
            $question->addTheme($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            $question->removeTheme($this);
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

    public function addManch(Manche $manch): self
    {
        if (!$this->manches->contains($manch)) {
            $this->manches[] = $manch;
            $manch->addTheme($this);
        }

        return $this;
    }

    public function removeManch(Manche $manch): self
    {
        if ($this->manches->contains($manch)) {
            $this->manches->removeElement($manch);
            $manch->removeTheme($this);
        }

        return $this;
    }
}