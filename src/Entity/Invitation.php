<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="invitations_sended")
     */
    private $user_sender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="invitations_recieved")
     */
    private $user_reciever;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->user_reciever = new ArrayCollection();
        $this->user_sender = new ArrayCollection();
        $this->setState(1); //1 active (invitation active), 2 les joueurs sont amis (invitation acceptée), 3 ne sont plus amis (suppresion de l'ami).
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(?int $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getUserSender(): ?User
    {
        return $this->user_sender;
    }

    public function setUserSender(?User $userSender): self
    {
        $this->user_sender = $userSender;

        return $this;
    }

    public function addUserSender(User $userSender): self
    {
        if (!$this->user_sender->contains($userSender)) {
            $this->user_sender[] = $userSender;
        }

        return $this;
    }

    public function removeUserSender(User $userSender): self
    {
        if ($this->user_sender->contains($userSender)) {
            $this->user_sender->removeElement($userSender);
        }

        return $this;
    }

    public function getUserReciever(): ?User
    {
        return $this->user_reciever;
    }

    public function setUserReciever(?User $userReciever): self
    {
        $this->user_reciever = $userReciever;

        return $this;
    }

    public function addUserReciever(User $userReciever): self
    {
        if (!$this->user_reciever->contains($userReciever)) {
            $this->user_reciever[] = $userReciever;
        }

        return $this;
    }

    public function removeUserReciever(User $userReciever): self
    {
        if ($this->user_reciever->contains($userReciever)) {
            $this->user_reciever->removeElement($userReciever);
        }

        return $this;
    }

}
