<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\WorkExperience;
use App\Entity\WorkExperienceTranslation;
use Doctrine\ORM\EntityManagerInterface;

final class WorkExperienceService
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function buildWorkExperience(): ?array
    {
        $workExperiences = $this->manager->getRepository(WorkExperience::class)->findAll();

        if (empty($workExperiences)) {
            return null;
        }

        $workExperienceArr = [];

        /**
         * @var WorkExperience $workExperience
         */
        foreach ($workExperiences as $workExperience) {
            $workExperienceArr[] = $this->mapWorkExperience($workExperience);
        }

        return $workExperienceArr;
    }

    public function mapWorkExperience(WorkExperience $workExperience): array
    {
        $translations = $this->mapTranslations($workExperience->getTranslations());

        return [
            'company' => $workExperience->getCompany(),
            'startDate' => $workExperience->getStartDate(),
            'endDate' => $workExperience->getEndDate(),
            'translations' => $translations,
        ];
    }

    public function mapTranslations($translations): array
    {
        $translationsArr = [];

        /**
         * @var WorkExperienceTranslation $translation
         */
        foreach ($translations as $key => $translation) {
            $translationsArr[$key] = [
                'title' => $translation->getTitle(),
                'description' => $translation->getDescription(),
            ];
        }

        return $translationsArr;
    }
}
