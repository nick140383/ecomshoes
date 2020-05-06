<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200418205114 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo ADD modele_chaussure_id INT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841876312859 FOREIGN KEY (modele_chaussure_id) REFERENCES modele_chaussure (id)');
        $this->addSql('CREATE INDEX IDX_14B7841876312859 ON photo (modele_chaussure_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841876312859');
        $this->addSql('DROP INDEX IDX_14B7841876312859 ON photo');
        $this->addSql('ALTER TABLE photo DROP modele_chaussure_id');
    }
}
