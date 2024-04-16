<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416212231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about_me CHANGE name name VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE photo_path photo_path VARCHAR(255) DEFAULT NULL, CHANGE curriculum_path curriculum_path VARCHAR(255) DEFAULT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE interpersonal_skills_translation ADD translatable_id INT DEFAULT NULL, ADD locale VARCHAR(5) NOT NULL');
        $this->addSql('ALTER TABLE interpersonal_skills_translation ADD CONSTRAINT FK_9BD8F3C02C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES interpersonal_skills (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_9BD8F3C02C2AC5D3 ON interpersonal_skills_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX interpersonal_skills_translation_unique_translation ON interpersonal_skills_translation (translatable_id, locale)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE interpersonal_skills_translation DROP FOREIGN KEY FK_9BD8F3C02C2AC5D3');
        $this->addSql('DROP INDEX IDX_9BD8F3C02C2AC5D3 ON interpersonal_skills_translation');
        $this->addSql('DROP INDEX interpersonal_skills_translation_unique_translation ON interpersonal_skills_translation');
        $this->addSql('ALTER TABLE interpersonal_skills_translation DROP translatable_id, DROP locale');
        $this->addSql('ALTER TABLE about_me CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE location location VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE photo_path photo_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE curriculum_path curriculum_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_uca1400_ai_ci`');
    }
}
