<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="votes")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Feuille", inversedBy="votes")
     */
    private $feuille;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vote_1_comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vote_2_comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vote_3_comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vote_4_comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vote_5_comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vote_6_comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vote_7_comment;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getFeuille(): ?Feuille
    {
        return $this->feuille;
    }

    public function setFeuille(?Feuille $feuille): self
    {
        $this->feuille = $feuille;

        return $this;
    }

    public function getVote1Comment(): ?string
    {
        return $this->vote_1_comment;
    }

    public function setVote1Comment(?string $vote_1_comment): self
    {
        $this->vote_1_comment = $vote_1_comment;

        return $this;
    }

    public function getVote2Comment(): ?string
    {
        return $this->vote_2_comment;
    }

    public function setVote2Comment(?string $vote_2_comment): self
    {
        $this->vote_2_comment = $vote_2_comment;

        return $this;
    }

    public function getVote3Comment(): ?string
    {
        return $this->vote_3_comment;
    }

    public function setVote3Comment(?string $vote_3_comment): self
    {
        $this->vote_3_comment = $vote_3_comment;

        return $this;
    }

    public function getVote4Comment(): ?string
    {
        return $this->vote_4_comment;
    }

    public function setVote4Comment(?string $vote_4_comment): self
    {
        $this->vote_4_comment = $vote_4_comment;

        return $this;
    }

    public function getVote5Comment(): ?string
    {
        return $this->vote_5_comment;
    }

    public function setVote5Comment(?string $vote_5_comment): self
    {
        $this->vote_5_comment = $vote_5_comment;

        return $this;
    }

    public function getVote6Comment(): ?string
    {
        return $this->vote_6_comment;
    }

    public function setVote6Comment(?string $vote_6_comment): self
    {
        $this->vote_6_comment = $vote_6_comment;

        return $this;
    }

    public function getVote7Comment(): ?string
    {
        return $this->vote_7_comment;
    }

    public function setVote7Comment(?string $vote_7_comment): self
    {
        $this->vote_7_comment = $vote_7_comment;

        return $this;
    }
}
