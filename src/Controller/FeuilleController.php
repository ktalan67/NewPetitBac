<?php

namespace App\Controller;

use App\Entity\Feuille;
use App\Form\FeuilleType;
use App\Form\FeuilleNewType;
use App\Repository\FeuilleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/main/feuille")
 */
class FeuilleController extends AbstractController
{
    /**
     * @Route("/", name="feuille_index", methods={"GET"})
     */
    public function index(FeuilleRepository $feuilleRepository): Response
    {
        return $this->render('feuille/index.html.twig', [
            'feuilles' => $feuilleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="feuille_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $feuille = new Feuille();
        $user = $this->getUser(); 
        $form = $this->createForm(FeuilleNewType::class, $feuille);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Enregistrement de la feuille au user
            $feuille->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feuille);
            $entityManager->flush();

            return $this->redirectToRoute('feuille_index');
        }

        return $this->render('feuille/new.html.twig', [
            'feuille' => $feuille,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="feuille_show", methods={"GET"})
     */
    public function show(Feuille $feuille): Response
    {
        return $this->render('feuille/show.html.twig', [
            'feuille' => $feuille,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="feuille_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Feuille $feuille): Response
    {
        $form = $this->createForm(FeuilleType::class, $feuille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('feuille_index');
        }

        return $this->render('feuille/edit.html.twig', [
            'feuille' => $feuille,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="feuille_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Feuille $feuille): Response
    {
        if ($this->isCsrfTokenValid('delete'.$feuille->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($feuille);
            $entityManager->flush();
        }

        return $this->redirectToRoute('feuille_index');
    }

    /**
     * @Route("/{id}/score", name="feuille_score", methods={"GET"})
     */
    public function score(Request $request, Feuille $feuille): Response
    {

        return $this->render('feuille/score.html.twig', [
            'feuille' => $feuille,
        ]);
    }
    
}
