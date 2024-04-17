<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Categories;
use App\Entity\CategoriesTranslation;
use Doctrine\ORM\EntityManagerInterface;

class TechnicalSkillsService
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function buildTechnicalSkills(): ?array
    {
        $categories = $this->manager->getRepository(Categories::class)->findAll();

        if (empty($categories)) {
            return null;
        }

        $categoriesArr = [];

        /**
         * @var Categories $category
         */
        foreach ($categories as $category) {
            $categoriesArr[] = $this->mapCategories($category);
        }

        return $categoriesArr;
    }

    private function mapCategories(Categories $category): array
    {
        $translations = $this->mapTranslations($category->getTranslations());
        $technicalSkills = $this->mapTechnicalSkills($category->getTechnicalSkills());

        return [
            'translations' => $translations,
            'technicalSkills' => $technicalSkills,
        ];
    }

    private function mapTranslations($translations): array
    {
        $translationsArr = [];

        /**
         * @var CategoriesTranslation $translation
         */
        foreach ($translations as $key => $translation) {
            $translationsArr[$key] = [
                'title' => $translation->getTitle(),
            ];
        }

        return $translationsArr;
    }

    private function mapTechnicalSkills($technicalSkills): array
    {
        $technicalSkillsArr = [];

        /**
         * @var CategoriesTranslation $translation
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
