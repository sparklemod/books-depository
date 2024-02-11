<?php

declare(strict_types=1);

namespace App\Services\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240211025409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE books_authors (book_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_877EACC216A2B381 (book_id), INDEX IDX_877EACC2F675F31B (author_id), PRIMARY KEY(book_id, author_id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE books_authors ADD CONSTRAINT FK_877EACC216A2B381 FOREIGN KEY (book_id) REFERENCES Books (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books_authors ADD CONSTRAINT FK_877EACC2F675F31B FOREIGN KEY (author_id) REFERENCES Authors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Authors DROP book_id, CHANGE name name VARCHAR(255) NOT NULL, CHANGE surname surname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE Books DROP author_id, CHANGE title title VARCHAR(255) NOT NULL, CHANGE year year DATETIME NOT NULL, CHANGE publisher_id publisher_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Books ADD CONSTRAINT FK_8BDA059640C86FCE FOREIGN KEY (publisher_id) REFERENCES Publishers (id)');
        $this->addSql('CREATE INDEX IDX_8BDA059640C86FCE ON Books (publisher_id)');
        $this->addSql('ALTER TABLE Publishers DROP book_id, CHANGE name name VARCHAR(255) NOT NULL, CHANGE adress adress VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE books_authors DROP FOREIGN KEY FK_877EACC216A2B381');
        $this->addSql('ALTER TABLE books_authors DROP FOREIGN KEY FK_877EACC2F675F31B');
        $this->addSql('DROP TABLE books_authors');
        $this->addSql('ALTER TABLE Authors ADD book_id INT NOT NULL, CHANGE name name VARCHAR(100) NOT NULL, CHANGE surname surname VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE Books DROP FOREIGN KEY FK_8BDA059640C86FCE');
        $this->addSql('DROP INDEX IDX_8BDA059640C86FCE ON Books');
        $this->addSql('ALTER TABLE Books ADD author_id VARCHAR(100) NOT NULL, CHANGE title title VARCHAR(100) NOT NULL, CHANGE year year DATE NOT NULL, CHANGE publisher_id publisher_id VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE Publishers ADD book_id INT NOT NULL, CHANGE name name VARCHAR(100) NOT NULL, CHANGE adress adress VARCHAR(150) NOT NULL');
    }
}
