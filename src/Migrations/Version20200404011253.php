<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200404011253 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feuille ADD reponse_1_comment VARCHAR(255) DEFAULT NULL, ADD reponse_2_comment VARCHAR(255) DEFAULT NULL, ADD reponse_3_comment VARCHAR(255) DEFAULT NULL, ADD reponse_4_comment VARCHAR(255) DEFAULT NULL, ADD reponse_5_comment VARCHAR(255) DEFAULT NULL, ADD reponse_6_comment VARCHAR(255) DEFAULT NULL, ADD reponse_7_comment VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feuille DROP reponse_1_comment, DROP reponse_2_comment, DROP reponse_3_comment, DROP reponse_4_comment, DROP reponse_5_comment, DROP reponse_6_comment, DROP reponse_7_comment');
    }
}
