<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220328131646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document_categorie (document_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_5B45FE95C33F7837 (document_id), INDEX IDX_5B45FE95BCF5E72D (categorie_id), PRIMARY KEY(document_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document_categorie ADD CONSTRAINT FK_5B45FE95C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document_categorie ADD CONSTRAINT FK_5B45FE95BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE categorie_document');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_document (categorie_id INT NOT NULL, document_id INT NOT NULL, INDEX IDX_E0EECB1CC33F7837 (document_id), INDEX IDX_E0EECB1CBCF5E72D (categorie_id), PRIMARY KEY(categorie_id, document_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE categorie_document ADD CONSTRAINT FK_E0EECB1CC33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_document ADD CONSTRAINT FK_E0EECB1CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE document_categorie');
    }
}
