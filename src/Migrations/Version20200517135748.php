<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200517135748 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, ville_id INT NOT NULL, nom VARCHAR(60) NOT NULL, prenom VARCHAR(60) NOT NULL, sexe VARCHAR(1) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(100) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, INDEX IDX_C7440455A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, livraison_id INT NOT NULL, mode_paiement_id INT NOT NULL, montant_ligne NUMERIC(10, 2) NOT NULL, date_commande DATE NOT NULL, INDEX IDX_6EEAA67D19EB6921 (client_id), INDEX IDX_6EEAA67D8E54FB25 (livraison_id), INDEX IDX_6EEAA67D438F5B63 (mode_paiement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_taille (commande_id INT NOT NULL, taille_id INT NOT NULL, INDEX IDX_740470ED82EA2E54 (commande_id), INDEX IDX_740470EDFF25611A (taille_id), PRIMARY KEY(commande_id, taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, modele_id INT NOT NULL, commentaire VARCHAR(255) NOT NULL, date_commentaire DATETIME NOT NULL, INDEX IDX_67F068BC19EB6921 (client_id), INDEX IDX_67F068BCAC14B70A (modele_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire_commande (commentaire_id INT NOT NULL, commande_id INT NOT NULL, INDEX IDX_9CFB6EA1BA9CD190 (commentaire_id), INDEX IDX_9CFB6EA182EA2E54 (commande_id), PRIMARY KEY(commentaire_id, commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, date_paiement DATE NOT NULL, date_facture DATE NOT NULL, date_limite_paiement DATE NOT NULL, base_htva NUMERIC(10, 2) NOT NULL, montant_tva NUMERIC(10, 2) NOT NULL, total_htva NUMERIC(10, 2) NOT NULL, total_ttc NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_FE86641082EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, ville_id INT NOT NULL, nom VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(100) NOT NULL, INDEX IDX_369ECA32A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, ville_id INT NOT NULL, date_livraison DATE NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_A60C9F1FA73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, fournisseur_id INT NOT NULL, nom VARCHAR(100) NOT NULL, INDEX IDX_5A6F91CE670C757F (fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele_chaussure (id INT AUTO_INCREMENT NOT NULL, marque_id INT NOT NULL, nom VARCHAR(100) NOT NULL, prix NUMERIC(10, 2) NOT NULL, description LONGTEXT DEFAULT NULL, cover_image VARCHAR(255) NOT NULL, INDEX IDX_ADB2C1854827B9B2 (marque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele_chaussure_commande (modele_chaussure_id INT NOT NULL, commande_id INT NOT NULL, INDEX IDX_C88CBD0D76312859 (modele_chaussure_id), INDEX IDX_C88CBD0D82EA2E54 (commande_id), PRIMARY KEY(modele_chaussure_id, commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele_chaussure_taille (modele_chaussure_id INT NOT NULL, taille_id INT NOT NULL, INDEX IDX_5AFFFE5376312859 (modele_chaussure_id), INDEX IDX_5AFFFE53FF25611A (taille_id), PRIMARY KEY(modele_chaussure_id, taille_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mode_paiement (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, modele_chaussure_id INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_14B7841876312859 (modele_chaussure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, modele_chaussure_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, pourcentage DOUBLE PRECISION NOT NULL, INDEX IDX_C11D7DD176312859 (modele_chaussure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taille (id INT AUTO_INCREMENT NOT NULL, taille INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, code_postal INT NOT NULL, nom VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D438F5B63 FOREIGN KEY (mode_paiement_id) REFERENCES mode_paiement (id)');
        $this->addSql('ALTER TABLE commande_taille ADD CONSTRAINT FK_740470ED82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_taille ADD CONSTRAINT FK_740470EDFF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCAC14B70A FOREIGN KEY (modele_id) REFERENCES modele_chaussure (id)');
        $this->addSql('ALTER TABLE commentaire_commande ADD CONSTRAINT FK_9CFB6EA1BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire_commande ADD CONSTRAINT FK_9CFB6EA182EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641082EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT FK_5A6F91CE670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE modele_chaussure ADD CONSTRAINT FK_ADB2C1854827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE modele_chaussure_commande ADD CONSTRAINT FK_C88CBD0D76312859 FOREIGN KEY (modele_chaussure_id) REFERENCES modele_chaussure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modele_chaussure_commande ADD CONSTRAINT FK_C88CBD0D82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modele_chaussure_taille ADD CONSTRAINT FK_5AFFFE5376312859 FOREIGN KEY (modele_chaussure_id) REFERENCES modele_chaussure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modele_chaussure_taille ADD CONSTRAINT FK_5AFFFE53FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841876312859 FOREIGN KEY (modele_chaussure_id) REFERENCES modele_chaussure (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD176312859 FOREIGN KEY (modele_chaussure_id) REFERENCES modele_chaussure (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC19EB6921');
        $this->addSql('ALTER TABLE commande_taille DROP FOREIGN KEY FK_740470ED82EA2E54');
        $this->addSql('ALTER TABLE commentaire_commande DROP FOREIGN KEY FK_9CFB6EA182EA2E54');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641082EA2E54');
        $this->addSql('ALTER TABLE modele_chaussure_commande DROP FOREIGN KEY FK_C88CBD0D82EA2E54');
        $this->addSql('ALTER TABLE commentaire_commande DROP FOREIGN KEY FK_9CFB6EA1BA9CD190');
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY FK_5A6F91CE670C757F');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D8E54FB25');
        $this->addSql('ALTER TABLE modele_chaussure DROP FOREIGN KEY FK_ADB2C1854827B9B2');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCAC14B70A');
        $this->addSql('ALTER TABLE modele_chaussure_commande DROP FOREIGN KEY FK_C88CBD0D76312859');
        $this->addSql('ALTER TABLE modele_chaussure_taille DROP FOREIGN KEY FK_5AFFFE5376312859');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841876312859');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD176312859');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D438F5B63');
        $this->addSql('ALTER TABLE commande_taille DROP FOREIGN KEY FK_740470EDFF25611A');
        $this->addSql('ALTER TABLE modele_chaussure_taille DROP FOREIGN KEY FK_5AFFFE53FF25611A');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A73F0036');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32A73F0036');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FA73F0036');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_taille');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE commentaire_commande');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE modele_chaussure');
        $this->addSql('DROP TABLE modele_chaussure_commande');
        $this->addSql('DROP TABLE modele_chaussure_taille');
        $this->addSql('DROP TABLE mode_paiement');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE taille');
        $this->addSql('DROP TABLE ville');
    }
}
