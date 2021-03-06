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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Feuille", mappedBy="questions")
     */
    private $feuilles;

    /**
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="questions")
     */
    private $theme;

    public function __construct()
    {
        $this->manches = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->feuilles = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
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
            $feuille->addQuestion($this);
        }

        return $this;
    }

    public function removeFeuille(Feuille $feuille): self
    {
        if ($this->feuilles->contains($feuille)) {
            $this->feuilles->removeElement($feuille);
            $feuille->removeQuestion($this);
        }

        return $this;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

}
