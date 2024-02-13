<?php

declare(strict_types=1);

namespace App\Services\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213162126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Books DROP FOREIGN KEY FK_8BDA059640C86FCE');
        $this->addSql('ALTER TABLE Books ADD CONSTRAINT FK_8BDA059640C86FCE FOREIGN KEY (publisher_id) REFERENCES Publishers (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Books DROP FOREIGN KEY FK_8BDA059640C86FCE');
        $this->addSql('ALTER TABLE Books ADD CONSTRAINT FK_8BDA059640C86FCE FOREIGN KEY (publisher_id) REFERENCES Publishers (id) ON DELETE CASCADE');
    }
}
