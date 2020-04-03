<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200403000429 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feuille ADD reponse_1_score INT DEFAULT NULL, ADD reponse_2_score INT DEFAULT NULL, ADD reponse_3_score INT DEFAULT NULL, ADD reponse_4_score INT DEFAULT NULL, ADD reponse_5_score INT DEFAULT NULL, ADD reponse_6_score INT DEFAULT NULL, ADD reponse_7_score INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feuille DROP reponse_1_score, DROP reponse_2_score, DROP reponse_3_score, DROP reponse_4_score, DROP reponse_5_score, DROP reponse_6_score, DROP reponse_7_score');
    }
}
