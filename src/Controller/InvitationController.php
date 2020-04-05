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
     * @Route("/{id}", name="user_invitations", methods={"GET"})
     */
    public function userInvitations($id, InvitationRepository $invitationRepository): Response
    {
        $user = $this->getUser();
        $id = $user->getId();

        return $this->render('invitation/index.html.twig', [
            'invitations' => $invitationRepository->findBy(array('user' => $id)),
            'invitations_demandes' => $invitationRepository->findBy(array('user_demande' => $id)),
        ]);
    }

    /**
     * @Route("/new", name="invitation_newfefe", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        $invitation = new Invitation();
        $form = $this->createForm(InvitationType::class, $invitation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $userRepository->findAll();
            $usernameList = [];
            foreach ($users as $user) {
                $userUsername = $user->getUsername();
                $usernameList[] = $userUsername;
            }
            $username = $form->get('username_given')->getData();
            if (in_array($username, $usernameList)) {
            //Recherche de l'user et son Id reçu du Form
                $userSearch = $userRepository->findOneByUsername($username);
                $invitation->setUser($userSearch);
                $userCurrent = $this->getUser();
                $invitation->setUserDemande($userCurrent);
                $invitation->setActive(true);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($invitation);
                $entityManager->flush();

                return $this->redirectToRoute('invitation_index');
            }
            else {
                throw $this->createAccessDeniedException('User non trouvé.');
            }
        }
        return $this->render('invitation/new.html.twig', [
            'invitation' => $invitation,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/show/{id}", name="invitation_show", methods={"GET"})
     */
    public function show(Invitation $invitation): Response
    {
        $user = $this->getUser();
        $id = $user->getId();
        return $this->render('invitation/show.html.twig', [
            'invitation' => $invitation,
            'user'=> $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="invitation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Invitation $invitation): Response
    {
        $form = $this->createForm(InvitationType::class, $invitation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('invitation_index');
        }

        return $this->render('invitation/edit.html.twig', [
            'invitation' => $invitation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="invitation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Invitation $invitation): Response
    {
        $user = $this->getUser();
        $id2 = $user->getId();
        if ($this->isCsrfTokenValid('delete'.$invitation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($invitation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_invitations', [
            'id' => $$id2,
        ]);
    }
}