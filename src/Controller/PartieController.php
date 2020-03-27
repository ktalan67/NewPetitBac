<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\Manche;
use App\Entity\Feuille;
use App\Form\GameNewType;
use App\Form\MancheNewType;
use App\Form\FeuilleNewType;
use App\Repository\GameRepository;
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
    public function newGame(Request $request, QuestionRepository $questionRepository): Response
    {
        $game = new Game();
        $manche = new Manche();
        $user = $this->getUser();
        $form = $this->createForm(GameNewType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $usersList = $game->getUsers();
           // NOMMAGE DE LA MANCHE... POUR LA RETROUVER ENSUITE ?
           $mancheNom = 'Manche-'.$user->getId().'-lol'; 
           $manche->setNom($mancheNom);
           $manche->setTemps(3);
           $manche->setCreatorId($user->getId());

        //Ajout des questions à la manche
            $questionsList = $questionRepository->findAll();
            $manche->addQuestion($questionsList[0]);
            $manche->addQuestion($questionsList[1]);
            $manche->addQuestion($questionsList[2]);
            $manche->addQuestion($questionsList[3]);
            $manche->addQuestion($questionsList[4]);
            $manche->addQuestion($questionsList[5]);
            $manche->addQuestion($questionsList[6]);
            $manche->addUser($user);
            
        //Ajout du creator à partir de l'user connecté
            $game->setCreatorId($user->getId());
        //ajout de la manche à chaque user
            foreach ($user as $usersList){
            $user->setManche($manche);
            $manche->addUser($user);
            }
        //ajout de la manche au game
            $game->addManche($manche);
            foreach ($user as $usersList){
            $game->addUser($user); 
            }
            // NOMMAGE DU GAME... POUR LE RETROUVER ENSUITE ?
            $gameNom = 'Game-'.$user->getId().'-lol'; 
            $game->setNom($gameNom);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manche);
            $entityManager->persist($game);
            $entityManager->flush();
            $id1 = $manche->getId();
            $id = $game->getId();
            return $this->redirectToRoute('manche', [
                'id1' => $id1,
                'id'=> $id,
                'manche' => $manche,
            ]);
        }

        return $this->render('partie/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/{id}/manche/new", name="nouvelle_manche", methods={"GET","POST"})
    */
    public function newManche($id, Request $request, GameRepository $gameRepository, QuestionRepository $questionRepository): Response
    {
        $game = $gameRepository->find($id);
        $manche = new Manche();
        $user = $this->getUser();
        $form = $this->createForm(MancheNewType::class, $manche);
        $form->handleRequest($request);

    // L'User est-il dans la liste des users du Game ? Sinon, "Non autorisé"
    //Recuperation de l'user et son Id
    $user = $this->getUser();
    $userId = $user->getId();
    //Recuperation de la liste des users du Game
    $usersList = $game->getUsers();
    //creation d'une liste des Ids des users de la manche
    $userGameIdList = [];
    foreach ($usersList as $userGame) {
    $userGameId = $userGame->getId();
    $userGameIdList[] = $userGameId;
    }
    //Vérification si User est dans la liste
    if (in_array($userId, $userGameIdList)) {

    //Comparaison ID feuilles avec ID User -> Si existe, user a deja repondu ->redirection manche index
    $feuillesList = $manche->getFeuilles();
    $feuilleMancheUsersList = [];
    $feuilleMancheUsersIdList = [];
    foreach ($feuillesList as $feuilleManche) {
        $feuilleMancheUser = $feuilleManche->getUser();
        $feuilleMancheUsersList[] = $feuilleMancheUser;
    }
    foreach ($feuilleMancheUsersList as $feuilleUserId) {
        $feuilleUserId = $feuilleUserId->getId();
        $feuilleMancheUsersIdList[] = $feuilleUserId;
    }
    if (in_array($userId, $feuilleMancheUsersIdList)) {
        throw $this->createAccessDeniedException('Déjà répondu.');
        //Redirection si deja repondu
        //return $this->redirectToRoute('manche', [
        //    'id' => $id,
        //]);
    }
    }
    // Créatin de l'accès non-autorisé pour la boucle (si User n'est pas dans la manche)
    else {
    throw $this->createAccessDeniedException('Non autorisé.');
            }


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
            $manche->addQuestion($questionsList[3]);
            $manche->addQuestion($questionsList[4]);
            $manche->addQuestion($questionsList[5]);
            $manche->addQuestion($questionsList[6]);
            $manche->addUser($user);
            
        //ajout de la manche à chaque user
            foreach ($user as $usersList){
            $user->setManche($manche);
            $manche->addUser($user);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manche);

            $entityManager->flush();
            $id1 = $manche->getId();
            $id = $game->getId();
            return $this->redirectToRoute('manche', [
                'id' => $id,
                'id1'=> $id1,
                'manche' => $manche,
            ]);
        }

        return $this->render('partie/manches/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
    * @Route("/{id}/manche/{id1}/feuille/new", name="nouvelle_feuille", methods={"GET","POST"})
    */
    public function NewFeuille($id, $id1, Request $request, MancheRepository $mancheRepository, FeuilleRepository $feuilleRepository, QuestionRepository $questionRepository): Response
    {
        //Recuperation de la manche 
        $manche = $mancheRepository->find($id1);
        // L'User est-il dans la liste des users de la manche ? Sinon, "Non autorisé"
        //Recuperation de l'user et son Id
        $user = $this->getUser();
        $userId = $user->getId();
        //Recuperation de la liste des users de la manche
        $usersList = $manche->getUsers();
        //creation d'une liste des Ids des users de la manche
        $userMancheIdList = [];
        foreach ($usersList as $userManche) {
        $userMancheId = $userManche->getId();
        $userMancheIdList[] = $userMancheId;
        }
        //Vérification si User est dans la liste
        if (in_array($userId, $userMancheIdList)) {
        //Comparaison ID feuilles avec ID User -> Si existe, user a deja repondu ->redirection manche index
        $feuillesList = $manche->getFeuilles();
        $feuilleMancheUsersList = [];
        $feuilleMancheUsersIdList = [];
        foreach ($feuillesList as $feuilleManche) {
            $feuilleMancheUser = $feuilleManche->getUser();
            $feuilleMancheUsersList[] = $feuilleMancheUser;
        }
        foreach ($feuilleMancheUsersList as $feuilleUserId) {
            $feuilleUserId = $feuilleUserId->getId();
            $feuilleMancheUsersIdList[] = $feuilleUserId;
        }
        if (in_array($userId, $feuilleMancheUsersIdList)) {
            throw $this->createAccessDeniedException('Déjà répondu.');
            //Redirection si deja repondu
            //return $this->redirectToRoute('manche', [
            //    'id' => $id,
            //]);
        }
        }
        // Créatin de l'accès non-autorisé pour la boucle (si User n'est pas dans la manche)
        else {
        throw $this->createAccessDeniedException('Non autorisé.');
                }
                
        $manche = $mancheRepository->find($id);
        $id1 = $manche->getId();
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
            return $this->redirectToRoute('manche', [
                'id' => $id,
                'id1' => $id1,
            ]);
        }
        return $this->render('partie/manches/reponses_form.html.twig', [
            'form' => $form->createView(),
            'question'=> $question,
            'manche' => $manche,
        ]);
}

    /**
    * @Route("/{id}/manche/{id1}", name="manche", methods={"GET","POST"})
    */
    public function mancheShow($id, $id1, Request $request, GameRepository $gameRepository, MancheRepository $mancheRepository, UserRepository $userRepository, FeuilleRepository $feuilleRepository, QuestionRepository $questionRepository): Response
    {
        //--Acces uniquement si l'user est sur la manche
        //Recuperation de la manche pour retrouver les users inscrits, création de la liste
        $game = $gameRepository->find($id);
        $manche = $mancheRepository->find($id1);
        // L'User est-il dans la liste des users de la manche ? Sinon, "Non autorisé"
        //Recuperation de l'user et son Id
        $user = $this->getUser();
        $userId = $user->getId();
        //Recuperation de la liste des users de la manche
        $usersList = $manche->getUsers();
        //creation d'une liste des Ids des users de la manche
        $userMancheIdList = [];
        foreach ($usersList as $userManche) {
        $userMancheId = $userManche->getId();
        $userMancheIdList[] = $userMancheId;
        }
        //Vérification si User est dans la liste
        if (in_array($userId, $userMancheIdList)) {

        $manche = $mancheRepository->find($id);
        $feuille = $feuilleRepository->findAll();
        $question = $questionRepository->findAll();
        return $this->render('partie/manches/manche1.html.twig', [
            'manche' => $manche,
            'user'=> $user,
            'feuille'=> $feuille,
            'question'=> $question,
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