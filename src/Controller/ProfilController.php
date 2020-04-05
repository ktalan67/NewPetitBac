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
    public function userProfil($id, InvitationRepository $invitationRepository): Response
    {
        $user = $this->getUser();
        $id = $user->getId();
        return $this->render('profil/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/invitations", name="user_invitations", methods={"GET","POST"})
     */
    public function userInvitations(Request $request, InvitationRepository $invitationRepository, UserRepository $userRepository, EntityManagerInterface $em): Response
        {
            $user = $this->getUser();
            $id = $user->getId();
            return $this->render('profil/invitations.html.twig', [
                'invitations' => $invitationRepository->findBy(array('user' => $id)),
                'invitations_demandes' => $invitationRepository->findBy(array('user_demande' => $id)),
                'user' => $user,
            ]);
        }

    /**
     * @Route("/{id}/invitations/new", name="invitation_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
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
                $user = $this->getUser();
            //Recherche de l'user et son Id reçu du Form
                $userSearch = $userRepository->findOneByUsername($username);
                $invitation->setUser($userSearch);
                $userCurrent = $this->getUser();
                $invitation->setUserDemande($userCurrent);
                $invitation->setActive(true);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($invitation);
                $entityManager->flush();
                $id = $userCurrent->getId();
                return $this->redirectToRoute('user_invitations', [
                    'id'=> $id,
                ]);
            }
            else {
                throw $this->createAccessDeniedException('User non trouvé.');
            }
        }
        return $this->render('invitation/new.html.twig', [
            'invitation' => $invitation,
            'form' => $form->createView(),
            'user'=> $user,
        ]);

    }

    /////////////  /**
    /////////////   * @Route("/{id}/amis", name="amis_index", methods={"GET","POST"})
    /////////////   */
    /////////////  public function userAmis(Request $request, AmisRepository $amisrepository, UserRepository $userRepository, EntityManagerInterface $em): Response
    /////////////      {
    /////////////          $user = $this->getUser();
    /////////////          $id = $user->getId();
    /////////////          return $this->render('profil/amis.html.twig', [
    /////////////              'amis' => $amisRepository->findBy(array('id' => $id)),
    /////////////              'user'=> $user,
    /////////////          ]);
    /////////////      }

    /**
     * @Route("/show/{id}", name="user_amis", methods={"GET"})
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
