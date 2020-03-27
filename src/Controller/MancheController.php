<?php

namespace App\Controller;

use App\Entity\Manche;
use App\Form\MancheType;
use App\Repository\MancheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/main/manche")
 */
class MancheController extends AbstractController
{
    /**
     * @Route("/", name="manche_index", methods={"GET"})
     */
    public function index(MancheRepository $mancheRepository): Response
    {
        return $this->render('manche/index.html.twig', [
            'manches' => $mancheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="manche_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $manche = new Manche();
        $form = $this->createForm(MancheType::class, $manche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manche);
            $entityManager->flush();

            return $this->redirectToRoute('manche_index');
        }

        return $this->render('manche/new.html.twig', [
            'manche' => $manche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="manche_show", methods={"GET"})
     */
    public function show(Manche $manche): Response
    {
        return $this->render('manche/show.html.twig', [
            'manche' => $manche,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="manche_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Manche $manche): Response
    {
        $form = $this->createForm(MancheType::class, $manche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('manche_index');
        }

        return $this->render('manche/edit.html.twig', [
            'manche' => $manche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="manche_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Manche $manche): Response
    {
        if ($this->isCsrfTokenValid('delete'.$manche->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($manche);
            $entityManager->flush();
        }

        return $this->redirectToRoute('manche_index');
    }
}
