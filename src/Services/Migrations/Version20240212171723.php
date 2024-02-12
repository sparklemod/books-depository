<?php

declare(strict_types=1);

namespace App\Services\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212171723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Authors CHANGE name name VARCHAR(255) NOT NULL, CHANGE surname surname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE Books CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE Publishers ADD address VARCHAR(255) NOT NULL, DROP adress, CHANGE name name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Authors CHANGE name name VARCHAR(150) NOT NULL, CHANGE surname surname VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE Books CHANGE title title VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE Publishers ADD adress VARCHAR(150) NOT NULL, DROP address, CHANGE name name VARCHAR(150) NOT NULL');
    }
}
