<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427072031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, img_cover VARCHAR(255) DEFAULT NULL, update_at DATETIME NOT NULL, published_at DATE NOT NULL, description LONGTEXT NOT NULL, author VARCHAR(255) NOT NULL, is_reserved TINYINT(1) NOT NULL, is_favorite TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_reservation (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, user_id INT NOT NULL, date_loan DATETIME DEFAULT NULL, date_return DATETIME DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_103F062916A2B381 (book_id), INDEX IDX_103F0629A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_book (type_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_1CEA6639C54C8C93 (type_id), INDEX IDX_1CEA663916A2B381 (book_id), PRIMARY KEY(type_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_reservation ADD CONSTRAINT FK_103F062916A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_reservation ADD CONSTRAINT FK_103F0629A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE type_book ADD CONSTRAINT FK_1CEA6639C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_book ADD CONSTRAINT FK_1CEA663916A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_reservation DROP FOREIGN KEY FK_103F062916A2B381');
        $this->addSql('ALTER TABLE type_book DROP FOREIGN KEY FK_1CEA663916A2B381');
        $this->addSql('ALTER TABLE type_book DROP FOREIGN KEY FK_1CEA6639C54C8C93');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_reservation');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE type_book');
    }
}
