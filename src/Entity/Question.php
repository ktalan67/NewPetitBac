<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
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
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Manche", mappedBy="questions")
     */
    private $manches;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Theme", inversedBy="questions")
     */
    private $theme;

    public function __construct()
    {
        $this->manches = new ArrayCollection();
        $this->theme = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
     * @return Collection|Manche[]
     */
    public function getManches(): Collection
    {
        return $this->manches;
    }

    public function addManche(Manche $manche): self
    {
        if (!$this->manches->contains($manche)) {
            $this->manches[] = $manche;
            $manche->addQuestion($this);
        }

        return $this;
    }

    public function removeManch(Manche $manche): self
    {
        if ($this->manches->contains($manche)) {
            $this->manches->removeElement($manche);
            $manche->removeQuestion($this);
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

}
