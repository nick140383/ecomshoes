<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200726122833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock DROP INDEX IDX_4B365660FF25611A, ADD UNIQUE INDEX UNIQ_4B365660FF25611A (taille_id)');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566076312859');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566076312859 FOREIGN KEY (modele_chaussure_id) REFERENCES modele_chaussure (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock DROP INDEX UNIQ_4B365660FF25611A, ADD INDEX IDX_4B365660FF25611A (taille_id)');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566076312859');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566076312859 FOREIGN KEY (modele_chaussure_id) REFERENCES modele_chaussure (id)');
    }
}
