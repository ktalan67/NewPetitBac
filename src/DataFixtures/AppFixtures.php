<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\Theme;
use App\Entity\Manche;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
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

        $manches = [
            'Manche 1',
            'Manche 2',
            'Dernière Manche',
            'Manche Subite!',
        ];




        // Liste des Users
        $usersList = [];
        //Création de 5 Users
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setPseudo($pseudos[$i]);
            $usersList[] = $user;
            $manager->persist($user);
        }

        // Liste des Themes
        $themesList = [];
        //Création de 10 Themes
        for ($i = 0; $i < 10; $i++) {
            $theme = new Theme();
            $theme->setNom($themes[$i]);
            $themesList[] = $theme;
            $manager->persist($theme);
        }

        // Liste des Questions
        $questionsList = [];
        //Création de 15 Questions
        for ($i = 0; $i < 15; $i++) {
            $question = new Question();
            $question->setTitle($questions[$i]);
            $questionsList[] = $question;
            $manager->persist($question);
        }

        // Liste des Manches
        $manchesList = [];
        //Création de 4 Manches
        for ($i = 0; $i < 4; $i++) {
            $manche = new Manche();
            $manche->setNom($manches[$i]);
            $manche->setTemps(2);
            // Attribution du theme à la manche
            shuffle($themesList);
            $manche->addTheme($themesList[0]);
            // Ajout Users à la manche
            $manche->addUser($usersList[0]);
            $manche->addUser($usersList[1]);
            $manche->addUser($usersList[2]);
            // Attribution de "questions" à la manche
            shuffle($questionsList);
            $manche->addQuestion($questionsList[0]);
            shuffle($questionsList);
            $manche->addQuestion($questionsList[1]);
            shuffle($questionsList);
            $manche->addQuestion($questionsList[2]);
            $manchesList[] = $manche;
            $manager->persist($manche);
        }
        //Création d'une Partie
        $game = new Game();
        $game->addUser($usersList[0]);
        $game->addUser($usersList[1]);
        $game->addUser($usersList[2]);
        $game->addManch($manchesList[0]);
        $game->addManch($manchesList[1]);
        $game->addManch($manchesList[2]);
        $manager->persist($game);
        $manager->flush();
    }
}
