<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303122628 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, cook_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, difficulty INT NOT NULL, duration INT NOT NULL, cost INT NOT NULL, ingredients LONGTEXT NOT NULL, description LONGTEXT NOT NULL, steps LONGTEXT NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, people INT NOT NULL, is_visible TINYINT(1) NOT NULL, likes INT DEFAULT NULL, INDEX IDX_DA88B1379E44E010 (cook_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1379E44E010 FOREIGN KEY (cook_id_id) REFERENCES cook (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE recipe');
    }
}
