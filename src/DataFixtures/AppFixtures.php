<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\Theme;
use App\Entity\Manche;
use App\Entity\Feuille;
use App\Entity\Question;
use App\Entity\UserReponses;
use App\Repository\ThemeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ThemeRepository $tr)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->themerepository = $tr;
    }

    public function load(ObjectManager $manager)
    {
        $pseudos = [
            'Richard',
            'Antoine',
            'Julien',
            'Simon',
            'Stephane',
        ];

        $themes = [
            'TV',
            'Culture Générale',
            'Art',
            'Technologie',
            'Politique',
            'Santé',
            'Cinema',
            'Sport',
            'Religion',
            'Littérature',
        ];

        $questions = [
            'Insulte',
            'Animal',
            'Métier',
            'Pays',
            'Aliment',
            'Film',
            'Acteur',
            'Medicament',
            'Star',
            'Poete',
            'Titre Chanson',
            'Chanteur',
            'Roi',
            'Marque Voiture',
            'Marque Eau',
        ];

//        $manches = [
//            'Manche 1',
//            'Manche 2',
//            'Dernière Manche',
//            'Manche Subite!',
//        ];

//        $usersReponses = [
//            'chien',
//            'plombier',
//            'banane',
//            'Batman',
//            'baleine',
//            'Samsung',
//            'Vittel',
//            'Renault',
//            'Mercedes',
//            'Manchester United',
//            'Girafe',
//            'Ours',
//            'Scarabet',
//            'Tomate',
//            'Pomme',
//            'Ananas',
//            'Litchi',
//            'Orange',
//            'Mandarine',
//            'Clémentine',
//            'Fraise',
//            'Myrtille',
//            'Melon',
//            'Citron',
//            'Raisin',
//        ];


        // Liste des Users
        $usersList = [];
        //Création de 5 Users
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername($pseudos[$i]);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                '123'
            ));
            $user->setRoles(["ROLE_USER"]);
            $usersList[] = $user;
            $manager->persist($user);
        }

        // Liste des Themes
        $themesList = [];
        //Création de 10 Themes
        foreach ($themes as $index => $themeNom) {
            $theme = new Theme();
            $theme->setNom($themeNom);
            $themesList[] = $theme;
            $manager->persist($theme);
        }
        $manager->flush();

        // Liste des Questions
        $questionsList = [];

        //Création de 7 Questions minimum par theme
        foreach ($themesList as $index => $theme) {
            foreach ($questions as $index => $qestionTitle) {
                $question = new Question();
                $question->setTitle($qestionTitle);
                $randomTheme = $this->themerepository->find($theme);
                $question->setTheme($randomTheme);
                $questionsList[] = $question;
                $manager->persist($question);
            }
        }



//        // Liste des Manches
//        $manchesList = [];
//        //Création de 4 Manches
//        for ($i = 0; $i < 2; $i++) {
//            $manche = new Manche();
//            $manche->setNom($manches[$i]);
//            $manche->setTemps(2);
//            // Attribution du theme à la manche
//            shuffle($themesList);
//            $manche->addTheme($themesList[0]);
//            // Ajout Users à la manche
//            $manche->addUser($usersList[0]);
//            $manche->addUser($usersList[1]);
//            $manche->addUser($usersList[2]);
//            // Attribution de "questions" à la manche
//            shuffle($questionsList);
//            $manche->addQuestion($questionsList[0]);
//            shuffle($questionsList);
//            $manche->addQuestion($questionsList[1]);
//            shuffle($questionsList);
//            $manche->addQuestion($questionsList[3]);
//            shuffle($questionsList);
//            $manche->addQuestion($questionsList[4]);
//            shuffle($questionsList);
//            $manche->addQuestion($questionsList[5]);
//            shuffle($questionsList);
//            $manche->addQuestion($questionsList[6]);
//            $manchesList[] = $manche;
//            $manager->persist($manche);
//        }
//        //Création d'une Partie
//        $game = new Game();
//        $game->addUser($usersList[0]);
//        $game->addUser($usersList[1]);
//        $game->addUser($usersList[2]);
//        $game->addManche($manchesList[0]);
//        $game->addManche($manchesList[1]);
//        $manager->persist($game);

//    //Création de deux Feuilles-réponses aléatoires (manche1)
//    //feuille 1 user 0
//        $feuille0 = new Feuille();
//        $feuille0->setReponse1($usersReponses[0]);
//        $feuille0->setReponse2($usersReponses[1]);
//        $feuille0->setReponse3($usersReponses[2]);
//        $feuille0->setReponse4($usersReponses[3]);
//        $feuille0->setReponse5($usersReponses[4]);
//        $feuille0->setReponse6($usersReponses[5]);
//        $feuille0->setReponse7($usersReponses[6]);
//        $feuille0->setUser($usersList[0]);
//        $feuille0->setGame($game);
//        $feuille0->setManche($manchesList[0]);
//        $manager->persist($feuille0);

        //feuille 2 user 0
//        $feuille02 = new Feuille();
//        $feuille02->setReponse1($usersReponses[0]);
//        $feuille02->setReponse2($usersReponses[1]);
//        $feuille02->setReponse3($usersReponses[2]);
//        $feuille02->setReponse4($usersReponses[3]);
//        $feuille02->setReponse5($usersReponses[4]);
//        $feuille02->setReponse6($usersReponses[5]);
//        $feuille02->setReponse7($usersReponses[6]);
//        $feuille02->setUser($usersList[0]);
//        $feuille02->setGame($game);
//        $feuille02->setManche($manchesList[1]);
//        $manager->persist($feuille02);
//
//        //feuille 1 user 1
//        $feuille1 = new Feuille();
//        $feuille1->setReponse1($usersReponses[7]);
//        $feuille1->setReponse2($usersReponses[8]);
//        $feuille1->setReponse3($usersReponses[9]);
//        $feuille1->setReponse4($usersReponses[10]);
//        $feuille1->setReponse5($usersReponses[11]);
//        $feuille1->setReponse6($usersReponses[12]);
//        $feuille1->setReponse7($usersReponses[13]);
//        $feuille1->setUser($usersList[1]);
//        $feuille1->setGame($game);
//        $feuille1->setManche($manchesList[0]);
//        $manager->persist($feuille1);
//
//        //feuille 2 user 1
//        $feuille12 = new Feuille();
//        $feuille12->setReponse1($usersReponses[7]);
//        $feuille12->setReponse2($usersReponses[8]);
//        $feuille12->setReponse3($usersReponses[9]);
//        $feuille12->setReponse4($usersReponses[10]);
//        $feuille12->setReponse5($usersReponses[11]);
//        $feuille12->setReponse6($usersReponses[12]);
//        $feuille12->setReponse7($usersReponses[13]);
//        $feuille12->setUser($usersList[1]);
//        $feuille12->setGame($game);
//        $feuille12->setManche($manchesList[1]);
//        $manager->persist($feuille12);

        $manager->flush();
    }
}
