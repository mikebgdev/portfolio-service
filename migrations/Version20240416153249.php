<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416153249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about_me CHANGE name name VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE photo_path photo_path VARCHAR(255) DEFAULT NULL, CHANGE curriculum_path curriculum_path VARCHAR(255) DEFAULT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE about_me_translation DROP paragraph3, DROP paragraph4, CHANGE paragraph1 paragraph1 LONGTEXT DEFAULT NULL, CHANGE paragraph2 paragraph2 LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about_me_translation ADD paragraph3 VARCHAR(255) DEFAULT NULL, ADD paragraph4 VARCHAR(255) DEFAULT NULL, CHANGE paragraph1 paragraph1 VARCHAR(255) DEFAULT NULL, CHANGE paragraph2 paragraph2 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE about_me CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE location location VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE photo_path photo_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE curriculum_path curriculum_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_uca1400_ai_ci`');
    }
}
