<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200415184648 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE modele_chaussure ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE modele_chaussure_commande DROP quantite, DROP prix');
        $this->addSql('ALTER TABLE modele_chaussure_taille DROP quantite_stock');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE modele_chaussure DROP description');
        $this->addSql('ALTER TABLE modele_chaussure_commande ADD quantite INT NOT NULL, ADD prix NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE modele_chaussure_taille ADD quantite_stock INT NOT NULL');
    }
}
