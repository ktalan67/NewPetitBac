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
 * @Route("/invitation")
 */
class InvitationController extends AbstractController
{


    /**
     * @Route("/{id}/invitation/accept", name="invitation_accept", methods={"GET","POST"})
     */
    public function invitationAccept($id, InvitationRepository $invitationRepository, EntityManagerInterface $em): Response
    {
        $invitation = $invitationRepository->find($id);

        $userReciever = $invitation->getUserReciever();
        $userSender = $invitation->getUserSender();

        $userReciever->addFriend($userSender);
        $userSender->addFriend($userReciever);
        $invitation->setState(2);

        $em->persist($invitation);
        $em->persist($userReciever);
        $em->persist($userSender);
        $em->flush();
        return $this->redirectToRoute('user_invitations', ['id' => $this->getUser()->getId()]);
    }

    /**
     * @Route("/delete/{id}", name="invitation_delete", methods={"GET"})
     */
    public function invitationDelete(Request $request, Invitation $invitation, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$invitation->getId(), $request->get('_token'))) {
        $em->remove($invitation);
        $em->flush();
        }

        return $this->redirectToRoute('user_invitations', ['id' => $this->getUser()->getId()]);
    }
}
