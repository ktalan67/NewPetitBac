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
        $feuille = new Feuille();
        $user = $this->getUser();
        $form = $this->createForm(GameNewType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $usersList = $game->getUsers();
           // NOMMAGE DE LA MANCHE... POUR LA RETROUVER ENSUITE ?
           $mancheNom = 'Manche-'.$user->getId().'-PremiereManche'; 
           $manche->setNom($mancheNom);
           $manche->setTemps(3);
           $manche->setCreatorId($user->getId());
           $manche->setGame($game);
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
        //Ajout du créateur à partir de l'user connecté
            $game->setCreatorId($user->getId());
        //ajout de la manche à chaque user
            foreach ($usersList as $userGame){
            $manche->addUser($userGame);
            }
        //ajout de la manche au game
            $game->addManche($manche);
            foreach ($user as $usersList){
            $game->addUser($user); 
            }

        //ajout d'une nouvelle feuille à chaque user et ajout des feuilles à la manche
            foreach ($user as $usersList){
            $user->addFeuille(new \Feuille())->setManche($manche);
            $feuille->addQuestion($questionsList[0]);
            $feuille->addQuestion($questionsList[1]);
            $feuille->addQuestion($questionsList[2]);
            $feuille->addQuestion($questionsList[3]);
            $feuille->addQuestion($questionsList[4]);
            $feuille->addQuestion($questionsList[5]);
            $feuille->addQuestion($questionsList[6]);
            }

            // NOMMAGE DU GAME... POUR LE RETROUVER ENSUITE ?
            $gameNom = 'Game-'.$user->getId().'-"Nom de la partie"'; 
            $game->setNom($gameNom);
            $game->setCreatorId($user->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manche);
            $entityManager->persist($game);
            $entityManager->persist($feuille);
            $entityManager->flush();
            $id1 = $manche->getId();
            $id = $game->getId();
            return $this->redirectToRoute('game_show', [
                'id'=> $id,
                'game' => $game,
                'manche' => $manche,
                'feuille' => $feuille,
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
           $usersList = $game->getUsers();
           // NOMMAGE DE LA MANCHE... POUR LA RETROUVER ENSUITE ?
           $mancheNom = 'Manche-'.$user->getId().'-nouvelle manche'; 
           $manche->setNom($mancheNom);
           $manche->setTemps(3);
           $manche->setCreatorId($user->getId());
           $manche->setGame($game);
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
        //Ajout des Users à la manche (à partir des données du game)
            foreach ($usersList as $userGame){
            $manche->addUser($userGame);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manche);

            $entityManager->flush();
            $id1 = $manche->getId();
            $id = $game->getId();
            return $this->redirectToRoute('game_show', [
                'id'=> $id,
                'game' => $game,
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
            //return $this->redirectToRoute('manche_show', [
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
            return $this->redirectToRoute('manche_show', [
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
    * @Route("/{id}/manche/{id1}", name="manche_show", methods={"GET","POST"})
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

        $feuilles = $feuilleRepository->findAll();
        $question = $questionRepository->findAll();
        return $this->render('partie/manches/manche_show.html.twig', [
            'manche' => $manche,
            'user'=> $user,
            'question'=> $question,
            'feuilles'=> $feuilles,
        ])
        ;}
        // Créatin de l'accès non-autorisé pour la boucle
        else {
        throw $this->createAccessDeniedException('Non autorisé.');
                }
    }

    /**
    * @Route("/{id}/", name="game_show", methods={"GET","POST"})
    */
    public function GameShow($id, Request $request, GameRepository $gameRepository, MancheRepository $mancheRepository, UserRepository $userRepository, FeuilleRepository $feuilleRepository, QuestionRepository $questionRepository): Response
    {
        //--Acces uniquement si l'user est sur la manche
        //Recuperation de la manche pour retrouver les users inscrits, création de la liste
        $game = $gameRepository->find($id);
        $manches = $game->getManches();
        // L'User est-il dans la liste des users de la manche ? Sinon, "Non autorisé"
        //Recuperation de l'user et son Id
        $user = $this->getUser();
        $userId = $user->getId();
        //Recuperation de la liste des users du game
        $usersGameList = $game->getUsers();
        //creation d'une liste des Ids des users du game
        $userGameIdList = [];
        foreach ($usersGameList as $userGame) {
        $userGameId = $userGame->getId();
        $userGameIdList[] = $userGameId;
        }

        //création d'une liste des feuilles de chaque manche
        $feuillesMancheList = [];
        foreach ($manches as $mancheFeuilles) {
            $mancheFeuilles->getFeuilles();
            $feuillesMancheList[] = $mancheFeuilles;
            }

        //Vérification si User est dans la liste
        if (in_array($userId, $userGameIdList)) {

        $game = $gameRepository->find($id);
        $feuille = $feuilleRepository->findAll();
        $question = $questionRepository->findAll();
        return $this->render('partie/show.html.twig', [
            'user'=> $user,
            'manches'=> $manches, 
            'question'=> $question,
            'feuille'=> $feuille,
            'game'=> $game,
            'feuillesMancheList', $feuillesMancheList,
        ])
        ;}
        // Créatin de l'accès non-autorisé pour la boucle
        else {
        throw $this->createAccessDeniedException('Non autorisé.');
                }
    }

    /**
    * @Route("/{id}/manche/{id1}/feuille/{id2}", name="ma_feuille", methods={"GET","POST"})
    */
    public function FeuilleMancheShow($id, $id1, $id2, Request $request, GameRepository $gameRepository, MancheRepository $mancheRepository, UserRepository $userRepository, FeuilleRepository $feuilleRepository, QuestionRepository $questionRepository): Response
    {
        //--Acces uniquement si l'user est sur la manche
        //Recuperation de la manche pour retrouver les users inscrits, création de la liste
        $game = $gameRepository->find($id);
        $manche = $mancheRepository->find($id1);
        $feuille = $feuilleRepository->find($id2);
        // L'User est-il dans la liste des users de la manche ? Sinon, "Non autorisé"
        //Recuperation de l'user et son Id
        $user = $this->getUser();
        $userId = $user->getId();
        $feuilleUserId = $feuille->getUser()->getId();
        //Vérification si User est dans la liste
        if ($userId == $feuilleUserId) {
        $game = $gameRepository->find($id);
        $manche = $mancheRepository->find($id);
        $feuille = $feuilleRepository->find($id2);
        $question = $questionRepository->findAll();
        return $this->render('partie/feuilles/ma_feuille.html.twig', [
            'manche' => $manche,
            'user'=> $user,
            'feuille'=> $feuille,
            'question'=> $question,
            'game' => $game,
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