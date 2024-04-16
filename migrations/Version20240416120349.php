<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416120349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE about_me (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, age INT DEFAULT NULL, email VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, photo_path VARCHAR(255) DEFAULT NULL, curriculum_path VARCHAR(255) DEFAULT NULL, paragraph1 VARCHAR(255) DEFAULT NULL, paragraph2 VARCHAR(255) DEFAULT NULL, paragraph3 VARCHAR(255) DEFAULT NULL, paragraph4 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE about_me');
    }
}
