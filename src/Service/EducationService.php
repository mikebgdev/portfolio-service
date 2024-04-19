<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Education;
use App\Entity\EducationTranslation;
use Doctrine\ORM\EntityManagerInterface;

class EducationService
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function buildEducation(): ?array
    {
        $educations = $this->manager->getRepository(Education::class)->findAll();

        if (empty($educations)) {
            return null;
        }

        $educationsArr = [];

        /**
         * @var Education $education
         */
        foreach ($educations as $education) {
            $educationsArr[] = $this->mapWorkExperience($education);
        }

        return $educationsArr;
    }

    public function mapWorkExperience(Education $education): array
    {
        $translations = $this->mapTranslations($education->getTranslations());

        return [
            'startDate' => $education->getStartDate(),
            'endDate' => $education->getEndDate(),
            'translations' => $translations,
        ];
    }

    public function mapTranslations($translations): array
    {
        $translationsArr = [];

        /**
         * @var EducationTranslation $translation
         */
        foreach ($translations as $key => $translation) {
            $translationsArr[$key] = [
                'title' => $translation->getTitle(),
                'educationalCenter' => $translation->getEducationalCenter(),
            ];
        }

        return $translationsArr;
    }
}
