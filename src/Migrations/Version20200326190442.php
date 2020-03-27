<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200326190442 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feuille ADD manche_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE feuille ADD CONSTRAINT FK_EF726C463E37BFAB FOREIGN KEY (manche_id) REFERENCES manche (id)');
        $this->addSql('CREATE INDEX IDX_EF726C463E37BFAB ON feuille (manche_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feuille DROP FOREIGN KEY FK_EF726C463E37BFAB');
        $this->addSql('DROP INDEX IDX_EF726C463E37BFAB ON feuille');
        $this->addSql('ALTER TABLE feuille DROP manche_id');
    }
}
