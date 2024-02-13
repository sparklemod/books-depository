<?php

declare(strict_types=1);

namespace App\Services\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240213055512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Authors_Books (author_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_5F42C73AF675F31B (author_id), INDEX IDX_5F42C73A16A2B381 (book_id), PRIMARY KEY(author_id, book_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE Authors_Books ADD CONSTRAINT FK_5F42C73AF675F31B FOREIGN KEY (author_id) REFERENCES Authors (id)');
        $this->addSql('ALTER TABLE Authors_Books ADD CONSTRAINT FK_5F42C73A16A2B381 FOREIGN KEY (book_id) REFERENCES Books (id)');
        $this->addSql('ALTER TABLE books_authors DROP FOREIGN KEY FK_877EACC216A2B381');
        $this->addSql('ALTER TABLE books_authors DROP FOREIGN KEY FK_877EACC2F675F31B');
        $this->addSql('DROP TABLE books_authors');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE books_authors (book_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_877EACC2F675F31B (author_id), INDEX IDX_877EACC216A2B381 (book_id), PRIMARY KEY(book_id, author_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE books_authors ADD CONSTRAINT FK_877EACC216A2B381 FOREIGN KEY (book_id) REFERENCES Books (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books_authors ADD CONSTRAINT FK_877EACC2F675F31B FOREIGN KEY (author_id) REFERENCES Authors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Authors_Books DROP FOREIGN KEY FK_5F42C73AF675F31B');
        $this->addSql('ALTER TABLE Authors_Books DROP FOREIGN KEY FK_5F42C73A16A2B381');
        $this->addSql('DROP TABLE Authors_Books');
    }
}
