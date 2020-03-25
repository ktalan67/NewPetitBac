<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200324042004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_manche (game_id INT NOT NULL, manche_id INT NOT NULL, INDEX IDX_DD5BCF23E48FD905 (game_id), INDEX IDX_DD5BCF233E37BFAB (manche_id), PRIMARY KEY(game_id, manche_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_user (game_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6686BA65E48FD905 (game_id), INDEX IDX_6686BA65A76ED395 (user_id), PRIMARY KEY(game_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, score INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_theme (question_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_A79EF60C1E27F6BF (question_id), INDEX IDX_A79EF60C59027487 (theme_id), PRIMARY KEY(question_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, experience INT DEFAULT NULL, meilleur_score INT DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manche (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, temps INT NOT NULL, score INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manche_user (manche_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F2D335D73E37BFAB (manche_id), INDEX IDX_F2D335D7A76ED395 (user_id), PRIMARY KEY(manche_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manche_question (manche_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_700F92883E37BFAB (manche_id), INDEX IDX_700F92881E27F6BF (question_id), PRIMARY KEY(manche_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manche_theme (manche_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_80BD19A83E37BFAB (manche_id), INDEX IDX_80BD19A859027487 (theme_id), PRIMARY KEY(manche_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feuille (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, reponse_1 VARCHAR(255) DEFAULT NULL, reponse_2 VARCHAR(255) DEFAULT NULL, reponse_3 VARCHAR(255) DEFAULT NULL, reponse_4 VARCHAR(255) DEFAULT NULL, reponse_5 VARCHAR(255) DEFAULT NULL, reponse_6 VARCHAR(255) DEFAULT NULL, reponse_7 VARCHAR(255) DEFAULT NULL, INDEX IDX_EF726C46A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat_manche (id INT AUTO_INCREMENT NOT NULL, score INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat_manche_user (resultat_manche_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_424C12E15ED19708 (resultat_manche_id), INDEX IDX_424C12E1A76ED395 (user_id), PRIMARY KEY(resultat_manche_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat_manche_manche (resultat_manche_id INT NOT NULL, manche_id INT NOT NULL, INDEX IDX_5AB99D7C5ED19708 (resultat_manche_id), INDEX IDX_5AB99D7C3E37BFAB (manche_id), PRIMARY KEY(resultat_manche_id, manche_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_manche ADD CONSTRAINT FK_DD5BCF23E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_manche ADD CONSTRAINT FK_DD5BCF233E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA65E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA65A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_theme ADD CONSTRAINT FK_A79EF60C1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_theme ADD CONSTRAINT FK_A79EF60C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_user ADD CONSTRAINT FK_F2D335D73E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_user ADD CONSTRAINT FK_F2D335D7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_question ADD CONSTRAINT FK_700F92883E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_question ADD CONSTRAINT FK_700F92881E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_theme ADD CONSTRAINT FK_80BD19A83E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_theme ADD CONSTRAINT FK_80BD19A859027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feuille ADD CONSTRAINT FK_EF726C46A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE resultat_manche_user ADD CONSTRAINT FK_424C12E15ED19708 FOREIGN KEY (resultat_manche_id) REFERENCES resultat_manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_manche_user ADD CONSTRAINT FK_424C12E1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_manche_manche ADD CONSTRAINT FK_5AB99D7C5ED19708 FOREIGN KEY (resultat_manche_id) REFERENCES resultat_manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_manche_manche ADD CONSTRAINT FK_5AB99D7C3E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game_manche DROP FOREIGN KEY FK_DD5BCF23E48FD905');
        $this->addSql('ALTER TABLE game_user DROP FOREIGN KEY FK_6686BA65E48FD905');
        $this->addSql('ALTER TABLE question_theme DROP FOREIGN KEY FK_A79EF60C1E27F6BF');
        $this->addSql('ALTER TABLE manche_question DROP FOREIGN KEY FK_700F92881E27F6BF');
        $this->addSql('ALTER TABLE question_theme DROP FOREIGN KEY FK_A79EF60C59027487');
        $this->addSql('ALTER TABLE manche_theme DROP FOREIGN KEY FK_80BD19A859027487');
        $this->addSql('ALTER TABLE game_user DROP FOREIGN KEY FK_6686BA65A76ED395');
        $this->addSql('ALTER TABLE manche_user DROP FOREIGN KEY FK_F2D335D7A76ED395');
        $this->addSql('ALTER TABLE feuille DROP FOREIGN KEY FK_EF726C46A76ED395');
        $this->addSql('ALTER TABLE resultat_manche_user DROP FOREIGN KEY FK_424C12E1A76ED395');
        $this->addSql('ALTER TABLE game_manche DROP FOREIGN KEY FK_DD5BCF233E37BFAB');
        $this->addSql('ALTER TABLE manche_user DROP FOREIGN KEY FK_F2D335D73E37BFAB');
        $this->addSql('ALTER TABLE manche_question DROP FOREIGN KEY FK_700F92883E37BFAB');
        $this->addSql('ALTER TABLE manche_theme DROP FOREIGN KEY FK_80BD19A83E37BFAB');
        $this->addSql('ALTER TABLE resultat_manche_manche DROP FOREIGN KEY FK_5AB99D7C3E37BFAB');
        $this->addSql('ALTER TABLE resultat_manche_user DROP FOREIGN KEY FK_424C12E15ED19708');
        $this->addSql('ALTER TABLE resultat_manche_manche DROP FOREIGN KEY FK_5AB99D7C5ED19708');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_manche');
        $this->addSql('DROP TABLE game_user');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_theme');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE manche');
        $this->addSql('DROP TABLE manche_user');
        $this->addSql('DROP TABLE manche_question');
        $this->addSql('DROP TABLE manche_theme');
        $this->addSql('DROP TABLE feuille');
        $this->addSql('DROP TABLE resultat_manche');
        $this->addSql('DROP TABLE resultat_manche_user');
        $this->addSql('DROP TABLE resultat_manche_manche');
    }
}
