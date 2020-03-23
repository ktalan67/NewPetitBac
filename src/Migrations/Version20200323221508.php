<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200323221508 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE resultat_manche_manche (resultat_manche_id INT NOT NULL, manche_id INT NOT NULL, INDEX IDX_5AB99D7C5ED19708 (resultat_manche_id), INDEX IDX_5AB99D7C3E37BFAB (manche_id), PRIMARY KEY(resultat_manche_id, manche_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resultat_manche_manche ADD CONSTRAINT FK_5AB99D7C5ED19708 FOREIGN KEY (resultat_manche_id) REFERENCES resultat_manche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resultat_manche_manche ADD CONSTRAINT FK_5AB99D7C3E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE resultat_manche_manche');
    }
}
