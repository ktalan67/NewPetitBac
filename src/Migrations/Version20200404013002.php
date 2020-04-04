<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200404013002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vote ADD vote_1_comment VARCHAR(255) DEFAULT NULL, ADD vote_2_comment VARCHAR(255) DEFAULT NULL, ADD vote_3_comment VARCHAR(255) DEFAULT NULL, ADD vote_4_comment VARCHAR(255) DEFAULT NULL, ADD vote_5_comment VARCHAR(255) DEFAULT NULL, ADD vote_6_comment VARCHAR(255) DEFAULT NULL, ADD vote_7_comment VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vote DROP vote_1_comment, DROP vote_2_comment, DROP vote_3_comment, DROP vote_4_comment, DROP vote_5_comment, DROP vote_6_comment, DROP vote_7_comment');
    }
}
