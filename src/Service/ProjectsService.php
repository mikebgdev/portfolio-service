<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Projects;
use App\Entity\ProjectsTranslation;
use Doctrine\ORM\EntityManagerInterface;

final class ProjectsService
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function buildProjects(): ?array
    {
        $projects = $this->manager->getRepository(Projects::class)->findAll();

        if (empty($projects)) {
            return null;
        }

        $projectsArr = [];

        /**
         * @var Projects $project
         */
        foreach ($projects as $project) {
            $projectsArr[] = $this->mapProjects($project);
        }

        return $projectsArr;
    }

    public function mapProjects(Projects $project): array
    {
        $translations = $this->mapTranslations($project->getTranslations());
        $technicalSkills = $this->mapTechnicalSkills($project->getTechnicalSkills());

        return [
            'title' => $project->getTitle(),
            'urlDemo' => $project->getUrlDemo(),
            'urlGit' => $project->getUrlGit(),
            'translations' => $translations,
            'technicalSkills' => $technicalSkills,
        ];
    }

    public function mapTranslations($translations): array
    {
        $translationsArr = [];

        /**
         * @var ProjectsTranslation $translation
         */
        foreach ($translations as $key => $translation) {
            $translationsArr[$key] = [
                'description' => $translation->getDescription(),
            ];
        }

        return $translationsArr;
    }

    public function mapTechnicalSkills($technicalSkills): array
    {
        $technicalSkillsArr = [];

        /**
         * @var ProjectsTranslation $translation
         */
        foreach ($technicalSkills as $technicalSkill) {
            $technicalSkillsArr[] = [
                'title' => $technicalSkill->getTitle(),
                'svg' => $technicalSkill->getSvg(),
            ];
        }

        return $technicalSkillsArr;
    }
}
