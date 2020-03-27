<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Manche;
use App\Entity\Feuille;
use App\Form\MancheNewType;
use App\Form\FeuilleNewType;
use App\Repository\UserRepository;
use App\Repository\MancheRepository;
use App\Repository\FeuilleRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/main/partie")
 */
class PartieController extends AbstractController
{
    /**
    * @Route("/", name="manche_index", methods={"GET"})
    */
    public function index(MancheRepository $mancheRepository): Response
    {
        return $this->render('partie/index.html.twig', [
            'manches' => $mancheRepository->findAll(),
        ]);
    }

    /**
    * @Route("/new", name="nouvelle_partie", methods={"GET","POST"})
    */
    public function new(Request $request, QuestionRepository $questionRepository): Response
    {
        $manche = new Manche();
        $user = $this->getUser();
        $form = $this->createForm(MancheNewType::class, $manche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $usersList = $manche->getUsers();
           // NOMMAGE DE LA MANCHE... POUR LA RETROUVER ENSUITE ?
           $mancheNom = 'Manche-'.$user->getId().'-lol'; 
           $manche->setNom($mancheNom);
           $manche->setTemps(3);

        //Ajout des questions à la manche
            $questionsList = $questionRepository->findAll();
            $manche->addQuestion($questionsList[0]);
            $manche->addQuestion($questionsList[1]);
            $manche->addQuestion($questionsList[2]);
            $manche->addUser($user);
            
        //ajout de la manche à chaque user
            foreach ($user as $usersList){
            $user->setManche($manche);
            $manche->addUser($user);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manche);

            $entityManager->flush();
            $id = $manche->getId();
            return $this->redirectToRoute('manche', [
                'id' => $id,
                'manche' => $manche,
            ]);
        }

        return $this->render('partie/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/reponses/{id}", name="etape_2", methods={"GET","POST"})
    */
    public function answers($id, Request $request, MancheRepository $mancheRepository, QuestionRepository $questionRepository): Response
    {
        //Vérification si User a deja répondu @TODO
        //
        // 
        //
        $manche = $mancheRepository->find($id);
        $question = $questionRepository->findAll();
        $feuille = new Feuille();
        $form = $this->createForm(FeuilleNewType::class, $feuille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $feuille->setUser($user);
            $feuille->setManche($manche);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feuille);
            $entityManager->flush();
            return $this->redirectToRoute('etape_3', [
                'id' => $id,
            ]);
        }

        return $this->render('partie/etape1a.html.twig', [
            'form' => $form->createView(),
            'question'=> $question,
            'manche' => $manche,
        ]);
    }

    /**
    * @Route("/manche/{id}", name="manche", methods={"GET","POST"})
    */
    public function mancheShow($id, Request $request, MancheRepository $mancheRepository, UserRepository $userRepository, FeuilleRepository $feuilleRepository, QuestionRepository $questionRepository): Response
    {
        //--Acces uniquement si l'user est sur la manche
        //Recuperation de la manche pour retrouver les users inscrits, création de la liste
        $manche = $mancheRepository->find($id);

        // L'User est-il dans la liste des users de la manche ? Sinon, "Non autorisé"
        //Recuperation de l'user et son username
        $user = $this->getUser();
        $username = $user->getUsername();
        //Recuperation de la liste des users de la manche
        $usersList = $manche->getUsers();
        //creation d'une liste des usernames de la manche
        $userMancheUsernameList = [];
        foreach ($usersList as $userManche) {
        $userMancheUsername = $userManche->getUsername();
        $userMancheUsernameList[] = $userMancheUsername;
        }
        //Vérification si User est dans la liste
        if (in_array($username, $userMancheUsernameList)) {

        $manche = $mancheRepository->find($id);
        $feuille = $feuilleRepository->findAll();
        $question = $questionRepository->findAll();
        return $this->render('partie/manches/manche1.html.twig', [
            'manche' => $manche,
            'user'=> $user,
            'feuille'=> $feuille,
            'question'=> $feuille,
        ])
        ;}
        // Créatin de l'accès non-autorisé pour la boucle
        else {
        throw $this->createAccessDeniedException('Non autorisé.');
                }

    }

    /**
    * @Route("/manche/first/control{id}", name="controle", methods={"GET","POST"})
    */
    public function ReponsesControle($id, Request $request, MancheRepository $mancheRepository, UserRepository $userRepository, FeuilleRepository $feuilleRepository, QuestionRepository $questionRepository): Response
    {
        $manche = $mancheRepository->find($id);
        $reponses = $manche->getReponses();
        dd($reponses);
        return $this->render('partie/manches/manche1.html.twig', [
            'manche' => $manche,
            'user'=> $user,
            'feuille'=> $feuille,
            'question'=> $feuille,
        ]);
    }

}