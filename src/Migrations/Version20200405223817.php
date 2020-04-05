<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405223817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, feuille_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, vote_1_comment VARCHAR(255) DEFAULT NULL, vote_2_comment VARCHAR(255) DEFAULT NULL, vote_3_comment VARCHAR(255) DEFAULT NULL, vote_4_comment VARCHAR(255) DEFAULT NULL, vote_5_comment VARCHAR(255) DEFAULT NULL, vote_6_comment VARCHAR(255) DEFAULT NULL, vote_7_comment VARCHAR(255) DEFAULT NULL, INDEX IDX_5A108564A76ED395 (user_id), INDEX IDX_5A10856465150016 (feuille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, creator_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_user (game_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6686BA65E48FD905 (game_id), INDEX IDX_6686BA65A76ED395 (user_id), PRIMARY KEY(game_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, score INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_theme (question_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_A79EF60C1E27F6BF (question_id), INDEX IDX_A79EF60C59027487 (theme_id), PRIMARY KEY(question_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, experience INT DEFAULT NULL, meilleur_score INT DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manche (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, temps INT NOT NULL, creator_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_A06E62EBE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manche_user (manche_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F2D335D73E37BFAB (manche_id), INDEX IDX_F2D335D7A76ED395 (user_id), PRIMARY KEY(manche_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manche_question (manche_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_700F92883E37BFAB (manche_id), INDEX IDX_700F92881E27F6BF (question_id), PRIMARY KEY(manche_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manche_theme (manche_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_80BD19A83E37BFAB (manche_id), INDEX IDX_80BD19A859027487 (theme_id), PRIMARY KEY(manche_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feuille (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, game_id INT DEFAULT NULL, manche_id INT DEFAULT NULL, reponse_1 VARCHAR(255) DEFAULT NULL, reponse_2 VARCHAR(255) DEFAULT NULL, reponse_3 VARCHAR(255) DEFAULT NULL, reponse_4 VARCHAR(255) DEFAULT NULL, reponse_5 VARCHAR(255) DEFAULT NULL, reponse_6 VARCHAR(255) DEFAULT NULL, reponse_7 VARCHAR(255) DEFAULT NULL, score INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, reponse_1_score INT DEFAULT NULL, reponse_2_score INT DEFAULT NULL, reponse_3_score INT DEFAULT NULL, reponse_4_score INT DEFAULT NULL, reponse_5_score INT DEFAULT NULL, reponse_6_score INT DEFAULT NULL, reponse_7_score INT DEFAULT NULL, reponse_1_comment VARCHAR(255) DEFAULT NULL, reponse_2_comment VARCHAR(255) DEFAULT NULL, reponse_3_comment VARCHAR(255) DEFAULT NULL, reponse_4_comment VARCHAR(255) DEFAULT NULL, reponse_5_comment VARCHAR(255) DEFAULT NULL, reponse_6_comment VARCHAR(255) DEFAULT NULL, reponse_7_comment VARCHAR(255) DEFAULT NULL, lettre VARCHAR(1) DEFAULT NULL, INDEX IDX_EF726C46A76ED395 (user_id), INDEX IDX_EF726C46E48FD905 (game_id), INDEX IDX_EF726C463E37BFAB (manche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feuille_question (feuille_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_2E1EAB0265150016 (feuille_id), INDEX IDX_2E1EAB021E27F6BF (question_id), PRIMARY KEY(feuille_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat_manche (id INT AUTO_INCREMENT NOT NULL, score INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat_manche_user (resultat_manche_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_424C12E15ED19708 (resultat_manche_id), INDEX IDX_424C12E1A76ED395 (user_id), PRIMARY KEY(resultat_manche_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat_manche_manche (resultat_manche_id INT NOT NULL, manche_id INT NOT NULL, INDEX IDX_5AB99D7C5ED19708 (resultat_manche_id), INDEX IDX_5AB99D7C3E37BFAB (manche_id), PRIMARY KEY(resultat_manche_id, manche_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invitation (id INT AUTO_INCREMENT NOT NULL, user_demande_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, active TINYINT(1) DEFAULT NULL, INDEX IDX_F11D61A2278E98F4 (user_demande_id), INDEX IDX_F11D61A2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856465150016 FOREIGN KEY (feuille_id) REFERENCES feuille (id)');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA65E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_user ADD CONSTRAINT FK_6686BA65A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_theme ADD CONSTRAINT FK_A79EF60C1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_theme ADD CONSTRAINT FK_A79EF60C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche ADD CONSTRAINT FK_A06E62EBE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE manche_user ADD CONSTRAINT FK_F2D335D73E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_user ADD CONSTRAINT FK_F2D335D7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_question ADD CONSTRAINT FK_700F92883E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_question ADD CONSTRAINT FK_700F92881E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_theme ADD CONSTRAINT FK_80BD19A83E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_theme ADD CONSTRAINT FK_80BD19A859027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feuille ADD CONSTRAINT FK_EF726C46A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE feuille ADD CONSTRAINT FK_EF726C46E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE feuille ADD CONSTRAINT FK_EF726C463E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id)');
        $this->addSql('ALTER TABLE feuille_question ADD CONSTRAINT FK_2E1EAB0265150016 FOREIGN KEY (feuille_id) REFERENCES feuille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feuille_question ADD CONSTRAINT FK_2E1EAB021E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_manche_user ADD CONSTRAINT FK_424C12E15ED19708 FOREIGN KEY (resultat_manche_id) REFERENCES resultat_manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_manche_user ADD CONSTRAINT FK_424C12E1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_manche_manche ADD CONSTRAINT FK_5AB99D7C5ED19708 FOREIGN KEY (resultat_manche_id) REFERENCES resultat_manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_manche_manche ADD CONSTRAINT FK_5AB99D7C3E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2278E98F4 FOREIGN KEY (user_demande_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game_user DROP FOREIGN KEY FK_6686BA65E48FD905');
        $this->addSql('ALTER TABLE manche DROP FOREIGN KEY FK_A06E62EBE48FD905');
        $this->addSql('ALTER TABLE feuille DROP FOREIGN KEY FK_EF726C46E48FD905');
        $this->addSql('ALTER TABLE question_theme DROP FOREIGN KEY FK_A79EF60C1E27F6BF');
        $this->addSql('ALTER TABLE manche_question DROP FOREIGN KEY FK_700F92881E27F6BF');
        $this->addSql('ALTER TABLE feuille_question DROP FOREIGN KEY FK_2E1EAB021E27F6BF');
        $this->addSql('ALTER TABLE question_theme DROP FOREIGN KEY FK_A79EF60C59027487');
        $this->addSql('ALTER TABLE manche_theme DROP FOREIGN KEY FK_80BD19A859027487');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('ALTER TABLE game_user DROP FOREIGN KEY FK_6686BA65A76ED395');
        $this->addSql('ALTER TABLE manche_user DROP FOREIGN KEY FK_F2D335D7A76ED395');
        $this->addSql('ALTER TABLE feuille DROP FOREIGN KEY FK_EF726C46A76ED395');
        $this->addSql('ALTER TABLE resultat_manche_user DROP FOREIGN KEY FK_424C12E1A76ED395');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2278E98F4');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2A76ED395');
        $this->addSql('ALTER TABLE manche_user DROP FOREIGN KEY FK_F2D335D73E37BFAB');
        $this->addSql('ALTER TABLE manche_question DROP FOREIGN KEY FK_700F92883E37BFAB');
        $this->addSql('ALTER TABLE manche_theme DROP FOREIGN KEY FK_80BD19A83E37BFAB');
        $this->addSql('ALTER TABLE feuille DROP FOREIGN KEY FK_EF726C463E37BFAB');
        $this->addSql('ALTER TABLE resultat_manche_manche DROP FOREIGN KEY FK_5AB99D7C3E37BFAB');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856465150016');
        $this->addSql('ALTER TABLE feuille_question DROP FOREIGN KEY FK_2E1EAB0265150016');
        $this->addSql('ALTER TABLE resultat_manche_user DROP FOREIGN KEY FK_424C12E15ED19708');
        $this->addSql('ALTER TABLE resultat_manche_manche DROP FOREIGN KEY FK_5AB99D7C5ED19708');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE game');
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
        $this->addSql('DROP TABLE feuille_question');
        $this->addSql('DROP TABLE resultat_manche');
        $this->addSql('DROP TABLE resultat_manche_user');
        $this->addSql('DROP TABLE resultat_manche_manche');
        $this->addSql('DROP TABLE invitation');
    }
}
