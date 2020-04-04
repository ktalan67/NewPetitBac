<?php

namespace App\Controller;

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
     * @Route("/", name="invitation_index", methods={"GET"})
     */
    public function index(InvitationRepository $invitationRepository): Response
    {
        return $this->render('invitation/index.html.twig', [
            'invitations' => $invitationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="invitation_new", methods={"GET","POST"})
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
            //Recupération du Username pour trouver son ID et lui affecter la demande

            //$userFoundId = $userFound->getId();

        //$query2 = $em->createQuery("SELECT id FROM App\Entity\User WHERE username = '.$username.");

            $invitation->setUserIdInvite($userFoundId);
            $userCurrent = $this->getUser();
            $userId = $userCurrent->getId();
            $invitation->setUserIdDemande($userId);
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
     * @Route("/{id}", name="invitation_show", methods={"GET"})
     */
    public function show(Invitation $invitation): Response
    {
        return $this->render('invitation/show.html.twig', [
            'invitation' => $invitation,
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
     * @Route("/{id}", name="invitation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Invitation $invitation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$invitation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($invitation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('invitation_index');
    }
}
