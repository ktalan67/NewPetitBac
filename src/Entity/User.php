<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $password;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $experience;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $meilleur_score;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Manche", mappedBy="users")
     */
    private $manches;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="users")
     */
    private $games;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ResultatManche", mappedBy="user")
     */
    private $resultatManches;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feuille", mappedBy="user")
     */
    private $feuilles;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vote", mappedBy="user")
     */
    private $votes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invitation", mappedBy="user_sender")
     */
    private $invitations_sended;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invitation", mappedBy="user_reciever")
     */
    private $invitations_recieved;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="user")
     */
    private $friends;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $total_games_won;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $total_games_played;
    
    public function __construct()
    {
        $this->manches = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->resultatManches = new ArrayCollection();
        $this->feuilles = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->votes = new ArrayCollection();
        $this->invitations_sended = new ArrayCollection();
        $this->invitations_recieved = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(?int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getMeilleurScore(): ?int
    {
        return $this->meilleur_score;
    }

    public function setMeilleurScore(?int $meilleur_score): self
    {
        $this->meilleur_score = $meilleur_score;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

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
            $manche->addUser($this);
        }

        return $this;
    }

    public function removeManche(Manche $manche): self
    {
        if ($this->manches->contains($manche)) {
            $this->manches->removeElement($manche);
            $manche->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->addUser($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            $game->removeUser($this);
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

    public function addResultatManche(ResultatManche $resultatManche): self
    {
        if (!$this->resultatManches->contains($resultatManche)) {
            $this->resultatManches[] = $resultatManche;
            $resultatManche->addUser($this);
        }

        return $this;
    }

    public function removeResultatManche(ResultatManche $resultatManche): self
    {
        if ($this->resultatManches->contains($resultatManche)) {
            $this->resultatManches->removeElement($resultatManche);
            $resultatManche->removeUser($this);
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
        if (!$this->feuille->contains($feuille)) {
            $this->feuille[] = $feuille;
            $feuille->setUser($this);
        }

        return $this;
    }

    public function removeFeuille(Feuille $feuille): self
    {
        if ($this->feuille->contains($feuille)) {
            $this->feuille->removeElement($feuille);
            // set the owning side to null (unless already changed)
            if ($feuille->getUser() === $this) {
                $feuille->setUser(null);
            }
        }

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
            $vote->setUser($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->contains($vote)) {
            $this->votes->removeElement($vote);
            // set the owning side to null (unless already changed)
            if ($vote->getUser() === $this) {
                $vote->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitationsSended(): Collection
    {
        return $this->invitations_sended;
    }

    public function addInvitationsSended(Invitation $invitationsSended): self
    {
        if (!$this->invitations_sended->contains($invitationsSended)) {
            $this->invitations_sended[] = $invitationsSended;
            $invitationsSended->addUserSender($this);
        }

        return $this;
    }

    public function removeInvitationsSended(Invitation $invitationsSended): self
    {
        if ($this->invitations_sended->contains($invitationsSended)) {
            $this->invitations_sended->removeElement($invitationsSended);
            $invitationsSended->removeUserSender($this);
        }

        return $this;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitationsRecieved(): Collection
    {
        return $this->invitations_recieved;
    }

    public function addInvitationsRecieved(Invitation $invitationsRecieved): self
    {
        if (!$this->invitations_recieved->contains($invitationsRecieved)) {
            $this->invitations_recieved[] = $invitationsRecieved;
            $invitationsRecieved->addUserReciever($this);
        }

        return $this;
    }

    public function removeInvitationsRecieved(Invitation $invitationsRecieved): self
    {
        if ($this->invitations_recieved->contains($invitationsRecieved)) {
            $this->invitations_recieved->removeElement($invitationsRecieved);
            $invitationsRecieved->removeUserReciever($this);
        }

        return $this;
    }

    /**
     * @return Collection|Friend[]
     */
    public function getFriends(): Collection
    {
        return $this->friends;
    }

    public function addFriend(User $friend): self
    {
        if (!$this->friends->contains($friend)) {
            $this->friends[] = $friend;
        }

        return $this;
    }

    public function removeFriend(User $friend): self
    {
        if ($this->friends->contains($friend)) {
            $this->friends->removeElement($friend);
        }

        return $this;
    }

    public function __toString()
    {
        return strval($this->friends);
    }

    public function getTotalGamesWon(): ?int
    {
        return $this->total_games_won;
    }

    public function setTotalGamesWon(?int $total_games_won): self
    {
        $this->total_games_won = $total_games_won;

        return $this;
    }

    public function getTotalGamesPlayed(): ?int
    {
        return $this->total_games_played;
    }

    public function setTotalGamesPlayed(?int $total_games_played): self
    {
        $this->total_games_played = $total_games_played;

        return $this;
    }
}
