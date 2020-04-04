<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeuilleRepository")
 */
class Feuille
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reponse_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reponse_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reponse_3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reponse_4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reponse_5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reponse_6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reponse_7;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="feuille")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="feuilles", cascade={"persist"})
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manche", inversedBy="feuilles", cascade={"persist"})
     */
    private $manche;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Question", inversedBy="feuilles")
     */
    private $questions;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reponse_1_score;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reponse_2_score;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reponse_3_score;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reponse_4_score;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reponse_5_score;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reponse_6_score;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reponse_7_score;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="feuille")
     */
    private $votes;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->questions = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponse1(): ?string
    {
        return $this->reponse_1;
    }

    public function setReponse1(?string $reponse_1): self
    {
        $this->reponse_1 = $reponse_1;

        return $this;
    }

    public function getReponse2(): ?string
    {
        return $this->reponse_2;
    }

    public function setReponse2(?string $reponse_2): self
    {
        $this->reponse_2 = $reponse_2;

        return $this;
    }

    public function getReponse3(): ?string
    {
        return $this->reponse_3;
    }

    public function setReponse3(?string $reponse_3): self
    {
        $this->reponse_3 = $reponse_3;

        return $this;
    }

    public function getReponse4(): ?string
    {
        return $this->reponse_4;
    }

    public function setReponse4(?string $reponse_4): self
    {
        $this->reponse_4 = $reponse_4;

        return $this;
    }

    public function getReponse5(): ?string
    {
        return $this->reponse_5;
    }

    public function setReponse5(?string $reponse_5): self
    {
        $this->reponse_5 = $reponse_5;

        return $this;
    }

    public function getReponse6(): ?string
    {
        return $this->reponse_6;
    }

    public function setReponse6(?string $reponse_6): self
    {
        $this->reponse_6 = $reponse_6;

        return $this;
    }

    public function getReponse7(): ?string
    {
        return $this->reponse_7;
    }

    public function setReponse7(?string $reponse_7): self
    {
        $this->reponse_7 = $reponse_7;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

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

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getManche(): ?Manche
    {
        return $this->manche;
    }

    public function setManche(?Manche $manche): self
    {
        $this->manche = $manche;

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

    public function getReponse1Score(): ?int
    {
        return $this->reponse_1_score;
    }

    public function setReponse1Score(?int $reponse_1_score): self
    {
        $this->reponse_1_score = $reponse_1_score;

        return $this;
    }
        public function addReponse1Score(?int $reponse_1_score): self
    {
        $this->reponse_1_score = $reponse_1_score;

        return $this;
    }

    public function getReponse2Score(): ?int
    {
        return $this->reponse_2_score;
    }

    public function setReponse2Score(?int $reponse_2_score): self
    {
        $this->reponse_2_score = $reponse_2_score;

        return $this;
    }

    public function getReponse3Score(): ?int
    {
        return $this->reponse_3_score;
    }

    public function setReponse3Score(?int $reponse_3_score): self
    {
        $this->reponse_3_score = $reponse_3_score;

        return $this;
    }

    public function getReponse4Score(): ?int
    {
        return $this->reponse_4_score;
    }

    public function setReponse4Score(?int $reponse_4_score): self
    {
        $this->reponse_4_score = $reponse_4_score;

        return $this;
    }

    public function getReponse5Score(): ?int
    {
        return $this->reponse_5_score;
    }

    public function setReponse5Score(?int $reponse_5_score): self
    {
        $this->reponse_5_score = $reponse_5_score;

        return $this;
    }

    public function getReponse6Score(): ?int
    {
        return $this->reponse_6_score;
    }

    public function setReponse6Score(?int $reponse_6_score): self
    {
        $this->reponse_6_score = $reponse_6_score;

        return $this;
    }

    public function getReponse7Score(): ?int
    {
        return $this->reponse_7_score;
    }

    public function setReponse7Score(?int $reponse_7_score): self
    {
        $this->reponse_7_score = $reponse_7_score;

        return $this;
    }

    /**
     * @return Collection|Vote[]
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setFeuille($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getFeuille() === $this) {
                $vote->setFeuille(null);
            }
        }

        return $this;
    }

}
