<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\Vote;
use App\Entity\Manche;
use App\Entity\Feuille;
use App\Form\GameNewType;
use App\Form\MancheNewType;
use App\Form\FeuilleNewType;
use App\Form\FeuilleVoteType;
use App\Form\VoteCommentType;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use App\Repository\VoteRepository;
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
    public function newGame(Request $request, QuestionRepository $questionRepository, EntityManagerInterface $em): Response
    {
        $game = new Game();
        $user = $this->getUser();
        $form = $this->createForm(GameNewType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $manche = new Manche();
           $nomPartie = $form->get('nom_partie')->getData();
           $usersList = $game->getUsers();
           // NOMMAGE DE LA MANCHE... POUR LA RETROUVER ENSUITE ?
           $mancheNom = 'Manche'.$user->getUsername; 
           $manche->setNom($mancheNom);
           $manche->setTemps(3);
           $manche->setCreatorId($user->getId());
           $manche->setGame($game);
        //Ajout de questions aléatoires à la manche
            $questions = $questionRepository->findAll();
            $questionsList = [];
            foreach ($questions as $question){
                $questionsList[] = $question;
            }
            $question1 = $questionsList[0];
            $manche->addQuestion($question1);
            shuffle($questionsList);
            $question2 = $questionsList[0];
            $manche->addQuestion($question2);
            shuffle($questionsList);
            $question3 = $questionsList[0];
            $manche->addQuestion($question3);
            shuffle($questionsList);
            $question4 = $questionsList[0];
            $manche->addQuestion($question4);
            shuffle($questionsList);
            $question5 = $questionsList[0];
            $manche->addQuestion($question5);
            shuffle($questionsList);
            $question6 = $questionsList[0];
            $manche->addQuestion($question6);
            shuffle($questionsList);
            $question7 = $questionsList[0];
            $manche->addQuestion($question7);
            $manche->addUser($user);
        //Ajout du créateur de la partie à partir de l'user connecté (creator_id , int   ->propriété sans relation)
            $game->setCreatorId($user->getId());
        //ajout de la partie et de la manche à chaque user
            foreach ($usersList as $userGame){
            $manche->addUser($userGame);
            $game->addUser($userGame); 
            $feuille = new Feuille();
            $feuille->setUser($userGame);
            $feuille->setManche($manche);
            $feuille->setGame($game);
            $feuille->addQuestion($question1); 
            $feuille->addQuestion($question2);
            $feuille->addQuestion($question3);
            $feuille->addQuestion($question4); 
            $feuille->addQuestion($question5);
            $feuille->addQuestion($question6);
            $feuille->addQuestion($question7);
            $em->persist($feuille);
            $em->flush();
            $em->clear(Feuille::class); // methode "magique" pour les boucles, "Detaches all Feuilles objects from Doctrine!"
            }
        //ajout de la manche au game
            $game->addManche($manche);
        // NOMMAGE DU GAME... POUR LE RETROUVER ENSUITE ?
            $game->setNom($nomPartie);
            $game->setCreatorId($user->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manche);
            $entityManager->persist($game);
            $entityManager->flush();
            $id = $game->getId();
            return $this->redirectToRoute('game_show', [
                'id'=> $id,
                'game' => $game,
                'manche' => $manche,
                'user'=> $user,
            ]);
        }
        return $this->render('partie/new.html.twig', [
            'form' => $form->createView(),
            'user'=> $user,
        ]);
    }

    /**
    * @Route("/{id}/manche/{id2}/feuille/{id3}/reponse", name="nouvelle_feuille_reponse", methods={"GET","POST"})
    */
    public function NewFeuilleReponse($id, $id2, $id3, Request $request,GameRepository $gameRepository, MancheRepository $mancheRepository, FeuilleRepository $feuilleRepository, QuestionRepository $questionRepository): Response
    {
        //Recuperation de la manche 
        $manche = $mancheRepository->find($id2);
        //Recuperation du game 
        $game = $gameRepository->find($id);
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
        //////////////////////////////////////////Vérification si User est dans la liste
        ////////////////////////////////////////if (in_array($userId, $userMancheIdList)) {
        //////////////////////////////////////////Comparaison ID feuilles avec ID User -> Si existe, user a deja repondu ->redirection manche index
        ////////////////////////////////////////$feuillesList = $manche->getFeuilles();
        ////////////////////////////////////////$feuilleMancheUsersList = [];
        ////////////////////////////////////////$feuilleMancheUsersIdList = [];
        ////////////////////////////////////////foreach ($feuillesList as $feuilleManche) {
        ////////////////////////////////////////    $feuilleMancheUser = $feuilleManche->getUser();
        ////////////////////////////////////////    $feuilleMancheUsersList[] = $feuilleMancheUser;
        ////////////////////////////////////////}
        ////////////////////////////////////////foreach ($feuilleMancheUsersList as $feuilleUserId) {
        ////////////////////////////////////////    $feuilleUserId = $feuilleUserId->getId();
        ////////////////////////////////////////    $feuilleMancheUsersIdList[] = $feuilleUserId;
        ////////////////////////////////////////}
        ////////////////////////////////////////if (in_array($userId, $feuilleMancheUsersIdList)) {
        ////////////////////////////////////////    throw $this->createAccessDeniedException('Déjà répondu.');
        ////////////////////////////////////////    //Redirection si deja repondu
        ////////////////////////////////////////    //return $this->redirectToRoute('manche_show', [
        ////////////////////////////////////////    //    'id' => $id,
        ////////////////////////////////////////    //]);
        ////////////////////////////////////////}
        ////////////////////////////////////////}
        ////////////////////////////////////////// Créatin de l'accès non-autorisé pour la boucle (si User n'est pas dans la manche)
        ////////////////////////////////////////else {
        ////////////////////////////////////////throw $this->createAccessDeniedException('Non autorisé.');
        ////////////////////////////////////////        }
                
        $manche = $mancheRepository->find($id);
        $id2 = $manche->getId();
        $question = $questionRepository->findAll();
        $feuille = $feuilleRepository->find($id3);
        $form = $this->createForm(FeuilleNewType::class, $feuille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            $user = $this->getUser();
            $feuille->setUser($user);
            $feuille->setManche($manche);
            $feuille->setGame($game);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feuille);
            $entityManager->flush();
            return $this->redirectToRoute('game_show', [
                'id'=> $id,
                'game' => $game,
                'manche' => $manche,
                'user'=> $user,
            ]);
        }
        return $this->render('partie/manches/reponses_form.html.twig', [
            'form' => $form->createView(),
            'question'=> $question,
            'manche' => $manche,
            'user'=> $user,
        ]);
}

    /**
    * @Route("/{id}/manche/new", name="nouvelle_manche", methods={"GET","POST"})
    */
    public function newManche($id, Request $request, GameRepository $gameRepository, QuestionRepository $questionRepository, EntityManagerInterface $em): Response
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
           $mancheNom = 'Manche-'.$user->getUsername(); 
           $manche->setNom($mancheNom);
           $manche->setTemps(3);
           $manche->setCreatorId($user->getId());
           $manche->setGame($game);
                //Ajout de questions aléatoires à la manche
                $questions = $questionRepository->findAll();
                $questionsList = [];
                foreach ($questions as $question){
                    $questionsList[] = $question;
                }
                $question1 = $questionsList[0];
                $manche->addQuestion($question1);
                shuffle($questionsList);
                $question2 = $questionsList[0];
                $manche->addQuestion($question2);
                shuffle($questionsList);
                $question3 = $questionsList[0];
                $manche->addQuestion($question3);
                shuffle($questionsList);
                $question4 = $questionsList[0];
                $manche->addQuestion($question4);
                shuffle($questionsList);
                $question5 = $questionsList[0];
                $manche->addQuestion($question5);
                shuffle($questionsList);
                $question6 = $questionsList[0];
                $manche->addQuestion($question6);
                shuffle($questionsList);
                $question7 = $questionsList[0];
                $manche->addQuestion($question7);
            $manche->addUser($user);  
        //Ajout des Users à la manche (à partir des données du game) et création des feuilles pour chaquer
            foreach ($usersList as $userGame){
            $manche->addUser($userGame);
            $feuille = new Feuille();
            $feuille->setUser($userGame);
            $feuille->setManche($manche);
            $feuille->setGame($game);
            $em->persist($feuille);
            $em->flush();
            $em->clear(Feuille::class); // methode "magique" pour les boucles, "Detaches all Feuilles objects from Doctrine!"
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
                'user'=> $user,
            ]);
        }

        return $this->render('partie/manches/new.html.twig', [
            'form' => $form->createView(),
            'user'=> $user,
        ]);
    }

    /**
    * @Route("/{id}/manche/{id2}", name="manche_show", methods={"GET","POST"})
    */
    public function mancheShow($id, $id2, Request $request, GameRepository $gameRepository, MancheRepository $mancheRepository, UserRepository $userRepository, FeuilleRepository $feuilleRepository, QuestionRepository $questionRepository): Response
    {
        //--Acces uniquement si l'user est sur la manche
        //Recuperation de la manche pour retrouver les users inscrits, création de la liste
        $game = $gameRepository->find($id);
        $manche = $mancheRepository->find($id2);
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
        $feuilles = $feuilleRepository->findAll();
        $question = $questionRepository->findAll();
        return $this->render('partie/show.html.twig', [
            'user'=> $user,
            'usersGameList' => $usersGameList,
            'manches'=> $manches, 
            'question'=> $question,
            'feuilles'=> $feuilles,
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
    * @Route("/{id}/manche/{id2}/feuille/{id3}", name="ma_feuille", methods={"GET","POST"})
    */
    public function FeuilleMancheShow($id, $id2, $id3, Request $request, GameRepository $gameRepository, MancheRepository $mancheRepository, UserRepository $userRepository, FeuilleRepository $feuilleRepository, QuestionRepository $questionRepository): Response
    {
        //--Acces uniquement si l'user est sur la manche
        //Recuperation de la manche pour retrouver les users inscrits, création de la liste
        $game = $gameRepository->find($id);
        $manche = $mancheRepository->find($id2);
        $feuille = $feuilleRepository->find($id3);
        // L'User est-il dans la liste des users de la manche ? Sinon, "Non autorisé"
        //Recuperation de l'user et son Id
        $user = $this->getUser();
        $userId = $user->getId();
        $feuilleUserId = $feuille->getUser()->getId();
        //Vérification si User est dans la liste
        //////////////////////////////////////////////////////////////////if ($userId == $feuilleUserId) {
        $game = $gameRepository->find($id);
        $manche = $mancheRepository->find($id2);
        $feuille = $feuilleRepository->find($id3);
        $question = $questionRepository->findAll();
        return $this->render('partie/feuilles/ma_feuille.html.twig', [
            'manche' => $manche,
            'user'=> $user,
            'feuille'=> $feuille,
            'question'=> $question,
            'game' => $game,
        ])
        ;//////////////////////////////////////////////////////////////////////////}
        // Créatin de l'accès non-autorisé pour la boucle
        //////////////////////////////////////////////////////////////////////else {
        //////////////////////////////////////////////////////////////////////throw $this->createAccessDeniedException('Non autorisé.');
        //////////////////////////////////////////////////////////////////////        }
    }

    /**
    * @Route("/{id}/manche/{id2}/vote/", name="vote_manche", methods={"GET","POST"})
    */
    public function MancheVote($id, $id2, Request $request, GameRepository $gameRepository, MancheRepository $mancheRepository, UserRepository $userRepository, FeuilleRepository $feuilleRepository, QuestionRepository $questionRepository): Response
    {
        //--Acces uniquement si l'user est sur la manche
        $user = $this->getUser();
        //Recuperation de la manche pour retrouver les users inscrits, création de la liste
        $game = $gameRepository->find($id);
        $manche = $mancheRepository->find($id2);
        $users = $manche->getUsers();
        // L'User est-il dans la liste des users de la manche ? Sinon, "Non autorisé"
        //Recuperation de l'user et son Id
        $user = $this->getUser();
        $userId = $user->getId();
        //Création des formulaires de vote pour chaque feuille
        foreach ($users as $userManche) {
            $userMancheId = $userManche->getId();
            $MancheUserIdList[] = $userMancheId;
            }
        //Recuperer les ids de chaque User de chaque feuille de la manche
        $MancheUserIdList = [];

        foreach ($users as $userManche) {
            $userMancheId = $userManche->getId();
            $MancheUserIdList[] = $userMancheId;
            }
        //Vérification si User est dans la liste
        ///////////////////////////////////////////////////////////////////////if ($userId == $MancheUserIdList) {
        $game = $gameRepository->find($id);
        $manche = $mancheRepository->find($id2);
        $question = $questionRepository->findAll();
        return $this->render('partie/manches/vote.html.twig', [
            'manche' => $manche,
            'user'=> $user,
            'question'=> $question,
            'game' => $game,
        ]);
        ////////////////////////////////////////////////////////////////////////////}
        // Créatin de l'accès non-autorisé pour la boucle
        /////////////////////////////////////////////////////////////////////////////else {
        /////////////////////////////////////////////////////////////////////////////throw $this->createAccessDeniedException('Non autorisé.');
        /////////////////////////////////////////////////////////////////////////////        }
    }

    /**
    * @Route("/{id}/manche/{id2}/feuille/{id3}/vote", name="reponse_feuille_vote", methods={"GET","POST"})
    */
    public function ReponseFeuilleVote($id, $id2,$id3, Request $request, GameRepository $gameRepository, MancheRepository $mancheRepository, UserRepository $userRepository, FeuilleRepository $feuilleRepository, QuestionRepository $questionRepository, VoteRepository $voteRepository, EntityManagerInterface $em): Response
    {
        //--Acces uniquement si l'user est sur la manche
        //Recuperation de la manche pour retrouver les users inscrits, création de la liste
        $game = $gameRepository->find($id);
        $manche = $mancheRepository->find($id2);
        $feuille = $feuilleRepository->find($id3);
        // L'User est-il dans la liste des users de la manche ? @TODO ->DECOMMENTER Sinon, "Non autorisé"
        //Recuperation de l'user et son Id
        $user = $this->getUser();
        $userId = $user->getId();

                    //Création d'un vote pour identifier l'user
                    $vote = new Vote();
                    $vote->setUser($user);
                    $vote->setFeuille($feuille);
        ////////////////////////////////////////////////////////////$feuilleUserId = $feuille->getUser()->getId();
        //Vérification su l'User a déjà voté ou si la feuille est à lui -> Redirection
        //récupération des votes de la feuille et mise en List
        //$votesUsersList = [];
        //$votesList = [];
        //$votesList[] = $feuille->getVotes();
        //
        //foreach ($votes as $voteUser) {
        //    $voteUser = $votes->getUser();
        //    $votesUsersIdList[] = $voteUserId;
        //    }
        //    dd($votesUsersIdList);
        //    if (in_array($userId, $votesUsersList)) {
        //        throw $this->createAccessDeniedException('Déjà répondu.');
        //        //Redirection si deja repondu
        //        //return $this->redirectToRoute('manche_show', [
        //        //    'id' => $id,
        //    }
            // Recupération des anciens scores reponses et score total pour les additioner aux nouveaux si "form is submit"
        $oldReponse1Score = $feuille->getReponse1Score();
        $oldReponse2Score = $feuille->getReponse2Score();
        $oldReponse3Score = $feuille->getReponse3Score();
        $oldReponse4Score = $feuille->getReponse4Score();
        $oldReponse5Score = $feuille->getReponse5Score();
        $oldReponse6Score = $feuille->getReponse6Score();
        $oldReponse7Score = $feuille->getReponse7Score();
        $oldScore = $feuille->getScore();

        $questions = $feuille->getQuestions();
        $form = $this->createForm(FeuilleVoteType::class, $feuille);
        $form2 = $this->createForm(VoteCommentType::class, $vote);
        $form->handleRequest($request);
        $form2->handleRequest($request);
        //Vérification si User est dans la liste
        //////////////////////////////////////////////////////////////////if ($userId == $feuilleUserId) {

        if ($form->isSubmitted() && $form->isValid()) {
            //Création de la liste des scores "reçus" pour calculer un array sum ensuite
            $scoreReponseList = [];
            $scoreReponseList[] = $Reponse1Score = $form->getData()->getReponse1Score();
            $scoreReponseList[] = $Reponse2Score = $form->getData()->getReponse2Score();
            $scoreReponseList[] = $Reponse3Score = $form->getData()->getReponse3Score();
            $scoreReponseList[] = $Reponse4Score = $form->getData()->getReponse4Score();
            $scoreReponseList[] = $Reponse5Score = $form->getData()->getReponse5Score();
            $scoreReponseList[] = $Reponse6Score = $form->getData()->getReponse6Score();
            $scoreReponseList[] = $Reponse7Score = $form->getData()->getReponse7Score();

            $feuille->setReponse1Score($Reponse1Score+$oldReponse1Score);
            $feuille->setReponse2Score($Reponse2Score+$oldReponse2Score);
            $feuille->setReponse3Score($Reponse3Score+$oldReponse3Score);
            $feuille->setReponse4Score($Reponse4Score+$oldReponse4Score);
            $feuille->setReponse5Score($Reponse5Score+$oldReponse5Score);
            $feuille->setReponse6Score($Reponse6Score+$oldReponse6Score);
            $feuille->setReponse7Score($Reponse7Score+$oldReponse7Score);
        // Ajout au score total à la feuille
            $answerScore = array_sum($scoreReponseList);
            $feuille->setScore($answerScore+$oldScore);

            $em->persist($feuille);
            $em->persist($vote);
            $em->flush();
        return $this->redirectToRoute('game_show', [
            'id'=> $id,
            'game' => $game,
            'manche' => $manche,
            'user'=> $user,
    
        ]);
        }
        return $this->render('partie/feuilles/vote_feuille.html.twig', [
            'manche' => $manche,
            'user'=> $user,
            'feuille'=> $feuille,
            'questions'=> $questions,
            'game' => $game,
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        ])
        ;
        //////////////////////////////////////////////////////////////////////////}
        // Créatin de l'accès non-autorisé pour la boucle
        //////////////////////////////////////////////////////////////////////else {
        //////////////////////////////////////////////////////////////////////throw $this->createAccessDeniedException('Non autorisé.');
        //////////////////////////////////////////////////////////////////////        }

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