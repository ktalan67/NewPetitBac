<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200326232245 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feuille ADD question_1 VARCHAR(255) DEFAULT NULL, ADD question_2 VARCHAR(255) DEFAULT NULL, ADD question_3 VARCHAR(255) DEFAULT NULL, ADD question_4 VARCHAR(255) DEFAULT NULL, ADD question_5 VARCHAR(255) DEFAULT NULL, ADD question_6 VARCHAR(255) DEFAULT NULL, ADD question_7 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feuille DROP question_1, DROP question_2, DROP question_3, DROP question_4, DROP question_5, DROP question_6, DROP question_7');
    }
}
