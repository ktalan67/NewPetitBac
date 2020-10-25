<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Invitation;
use App\Form\InvitationType;
use App\Repository\UserRepository;
use App\Repository\InvitationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/{id}/profil/", name="user_profil", methods={"GET"})
     */
    public function userProfil(): Response
    {
        $user = $this->getUser();
        $friends = $user->getFriends();
        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'friends' => $friends
        ]);
    }

    /**
     * @Route("/{id}/invitations", name="user_invitations", methods={"GET","POST"})
     */
    public function userInvitations(Request $request, InvitationRepository $invitationRepository, UserRepository $userRepository, EntityManagerInterface $em): Response
        {
            $user = $this->getUser();
            return $this->render('profil/invitations.html.twig', [
                'invitations_sended' => $invitationRepository->findBy(['user_sender' => $user, 'state' => 1]),
                'invitations_recieved' => $invitationRepository->findBy(['user_reciever' => $user, 'state' => 1]),
                'user' => $user,
                'friends' => $user->getFriends(),
            ]);
        }

    /**
     * @Route("/{id}/invitations/new", name="invitation_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository, InvitationRepository $invitationRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $invitation = new Invitation();
        $form = $this->createForm(InvitationType::class, $invitation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userReciever = $userRepository->findOneBy(['username' => $form->get('username_given')->getNormData()]);
            $invitationExist = $invitationRepository->findOneBy(['user_reciever' => $userReciever, 'user_sender' => $user]);
            $invitationOtherSideExist = $invitationRepository->findOneBy(['user_reciever' => $user, 'user_sender' => $userReciever]);

            //Règles de création
            //Cas 1 : Le joueur s'invite lui-même
            if ($userReciever == $user){
                throw $this->createAccessDeniedException('Pourquoi s\inviter soit-même...?');
            }
            //Cas 2 : Les joueurs sont déjà amis
            $friends = $user->getFriends();
            if ($friends->contains($userReciever)){
                throw $this->createAccessDeniedException('Vous êtes déjà ami avec ce joueur.');
            }
            //Cas 3 : Le joueur invite un autre joueur qui n'existe pas
            if ($userReciever == null) {
                throw $this->createAccessDeniedException('Joueur non trouvé.');
            }
            if ($userReciever != null){
                if ($invitationExist == null && $invitationOtherSideExist == null) {
                    $invitation->setUserReciever($userReciever);
                    $invitation->setUserSender($user);
                    $em->persist($invitation);
                    $em->flush();
                    return $this->redirectToRoute('user_invitations', [
                        'id' => $user->getId(),
                    ]);
                }
                // Cas : Les joueurs ne sont PLUS amis (invitation State 3)
                if ($invitationExist != null && ($invitationExist->getState() == 3 || $invitationExist->getState() == 3)){
                    if($invitationExist == null){
                        $invitationOtherSideExist->setState(1);
                        $em->persist($invitationOtherSideExist);
                        $em->flush();
                        return $this->redirectToRoute('user_invitations', [
                            'id' => $user->getId(),
                        ]);
                    }
                    if($invitationOtherSideExist == null){
                        $invitationExist->setState(1);
                        $em->persist($invitationExist);
                        $em->flush();
                        return $this->redirectToRoute('user_invitations', [
                            'id' => $user->getId(),
                        ]);
                    }
                }
                //Cas 4 : Le joueur a déjà envoyée une invitation, mais elle est en attente
                if ($invitationExist != null && $invitationExist->getUserSender() === $user) {
                    throw $this->createAccessDeniedException('Vous avez déja envoyé une invitation à ce joueur.');
                }
                //Cas 5 : Le joueur a déjà reçu une invitation de l'autre joueur
                if ($invitationOtherSideExist != null && $invitationOtherSideExist->getUserReciever() === $user) {
                    throw $this->createAccessDeniedException('Ce joueur vous a déjà invité. Veuillez accepter son invitation');
                }
            }
        }

        return $this->render('invitation/new.html.twig', [
            'invitation' => $invitation,
            'form' => $form->createView(),
            'user'=> $user,
        ]);

    }

    /**
     * @Route("/friend/delete/{id}", name="friend_delete", methods={"GET"})
     */
    public function friendDelete($id, Request $request, User $friend, UserRepository $userRepository, InvitationRepository $invitationRepository, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$friend->getId(), $request->get('_token'))) {
            $otherUser = $userRepository->find($id);
            $user = $this->getUser();

            $invitationA = $invitationRepository->findOneBy(['user_sender' => $user, 'user_reciever' => $otherUser]);
            $invitationB = $invitationRepository->findOneBy(['user_sender' => $otherUser, 'user_reciever' => $user]);
            //On supprime l'invitation pour que l'user puisse réinviter par la suite
            if($invitationA == null){
                $em->remove($invitationB);
                $invitationB->setState(3);
                $em->persist($invitationB);
            }
            if($invitationB == null){
                $invitationA->setState(3);
                $em->persist($invitationA);
            }
            $user->removeFriend($otherUser);
            $otherUser->removeFriend($user);

            $em->flush();
        }

        return $this->redirectToRoute('user_invitations', ['id' => $this->getUser()->getId()]);
    }
}
