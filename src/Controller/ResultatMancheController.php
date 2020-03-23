<?php

namespace App\Controller;

use App\Entity\ResultatManche;
use App\Form\ResultatMancheType;
use App\Repository\ResultatMancheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resultat/manche")
 */
class ResultatMancheController extends AbstractController
{
    /**
     * @Route("/", name="resultat_manche_index", methods={"GET"})
     */
    public function index(ResultatMancheRepository $resultatMancheRepository): Response
    {
        return $this->render('resultat_manche/index.html.twig', [
            'resultat_manches' => $resultatMancheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="resultat_manche_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $resultatManche = new ResultatManche();
        $form = $this->createForm(ResultatMancheType::class, $resultatManche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resultatManche);
            $entityManager->flush();

            return $this->redirectToRoute('resultat_manche_index');
        }

        return $this->render('resultat_manche/new.html.twig', [
            'resultat_manche' => $resultatManche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resultat_manche_show", methods={"GET"})
     */
    public function show(ResultatManche $resultatManche): Response
    {
        return $this->render('resultat_manche/show.html.twig', [
            'resultat_manche' => $resultatManche,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="resultat_manche_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ResultatManche $resultatManche): Response
    {
        $form = $this->createForm(ResultatMancheType::class, $resultatManche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resultat_manche_index');
        }

        return $this->render('resultat_manche/edit.html.twig', [
            'resultat_manche' => $resultatManche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resultat_manche_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ResultatManche $resultatManche): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resultatManche->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($resultatManche);
            $entityManager->flush();
        }

        return $this->redirectToRoute('resultat_manche_index');
    }
}
