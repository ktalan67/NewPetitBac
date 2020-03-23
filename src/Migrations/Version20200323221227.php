<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200323221227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE manche_question (manche_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_700F92883E37BFAB (manche_id), INDEX IDX_700F92881E27F6BF (question_id), PRIMARY KEY(manche_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat_manche (id INT AUTO_INCREMENT NOT NULL, score INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat_manche_user (resultat_manche_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_424C12E15ED19708 (resultat_manche_id), INDEX IDX_424C12E1A76ED395 (user_id), PRIMARY KEY(resultat_manche_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE manche_question ADD CONSTRAINT FK_700F92883E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manche_question ADD CONSTRAINT FK_700F92881E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_manche_user ADD CONSTRAINT FK_424C12E15ED19708 FOREIGN KEY (resultat_manche_id) REFERENCES resultat_manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_manche_user ADD CONSTRAINT FK_424C12E1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE resultat_manche_user DROP FOREIGN KEY FK_424C12E15ED19708');
        $this->addSql('DROP TABLE manche_question');
        $this->addSql('DROP TABLE resultat_manche');
        $this->addSql('DROP TABLE resultat_manche_user');
    }
}
