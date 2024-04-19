<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419130931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, url_demo VARCHAR(255) DEFAULT NULL, url_git VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects_technical_skills (projects_id INT NOT NULL, technical_skills_id INT NOT NULL, INDEX IDX_43ACA2951EDE0F55 (projects_id), INDEX IDX_43ACA2952494BC8A (technical_skills_id), PRIMARY KEY(projects_id, technical_skills_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_E9B7E1FC2C2AC5D3 (translatable_id), UNIQUE INDEX projects_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects_technical_skills ADD CONSTRAINT FK_43ACA2951EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_technical_skills ADD CONSTRAINT FK_43ACA2952494BC8A FOREIGN KEY (technical_skills_id) REFERENCES technical_skills (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_translation ADD CONSTRAINT FK_E9B7E1FC2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE about_me CHANGE name name VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE photo_path photo_path VARCHAR(255) DEFAULT NULL, CHANGE curriculum_path curriculum_path VARCHAR(255) DEFAULT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects_technical_skills DROP FOREIGN KEY FK_43ACA2951EDE0F55');
        $this->addSql('ALTER TABLE projects_technical_skills DROP FOREIGN KEY FK_43ACA2952494BC8A');
        $this->addSql('ALTER TABLE projects_translation DROP FOREIGN KEY FK_E9B7E1FC2C2AC5D3');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE projects_technical_skills');
        $this->addSql('DROP TABLE projects_translation');
        $this->addSql('ALTER TABLE about_me CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE location location VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE photo_path photo_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_uca1400_ai_ci`, CHANGE curriculum_path curriculum_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_uca1400_ai_ci`');
    }
}
