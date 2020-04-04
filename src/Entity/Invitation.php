<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvitationRepository")
 */
class Invitation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_id_demande;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_id_invite;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserIdDemande(): ?int
    {
        return $this->user_id_demande;
    }

    public function setUserIdDemande(?int $user_id_demande): self
    {
        $this->user_id_demande = $user_id_demande;

        return $this;
    }

    public function getUserIdInvite(): ?int
    {
        return $this->user_id_invite;
    }

    public function setUserIdInvite(?int $user_id_invite): self
    {
        $this->user_id_invite = $user_id_invite;

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
