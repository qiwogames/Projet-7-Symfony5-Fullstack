<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210409102445 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit ADD reference_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC271645DEA9 FOREIGN KEY (reference_id) REFERENCES reference (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC271645DEA9 ON produit (reference_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC271645DEA9');
        $this->addSql('DROP INDEX UNIQ_29A5EC271645DEA9 ON produit');
        $this->addSql('ALTER TABLE produit DROP reference_id');
    }
}
