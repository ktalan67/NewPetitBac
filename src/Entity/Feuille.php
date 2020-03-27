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
     * @ORM\ManyToOne(targetEntity="App\Entity\Manche", inversedBy="feuilles")
     */
    private $manche;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score;

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

    public function getManche(): ?Manche
    {
        return $this->manche;
    }

    public function setManche(?Manche $manche): self
    {
        $this->manche = $manche;

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

}
