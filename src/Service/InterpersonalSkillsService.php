<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\InterpersonalSkills;
use App\Entity\InterpersonalSkillsTranslation;
use Doctrine\ORM\EntityManagerInterface;

final class InterpersonalSkillsService
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function buildInterpersonalSkills(): ?array
    {
        $interpersonalSkills = $this->manager->getRepository(InterpersonalSkills::class)->findAll();

        if (empty($interpersonalSkills)) {
            return null;
        }

        $interpersonalSkillsArr = [];

        /**
         * @var InterpersonalSkills $interpersonalSkill
         */
        foreach ($interpersonalSkills as $interpersonalSkill) {
            $interpersonalSkillsArr[] = $this->mapInterpersonalSkills($interpersonalSkill);
        }

        return $interpersonalSkillsArr;
    }

    public function mapInterpersonalSkills(InterpersonalSkills $interpersonalSkill): array
    {
        $translations = $this->mapTranslations($interpersonalSkill->getTranslations());

        return [
            'svg' => $interpersonalSkill->getSvg(),
            'translations' => $translations,
        ];
    }

    public function mapTranslations($translations): array
    {
        $translationsArr = [];

        /**
         * @var InterpersonalSkillsTranslation $translation
         */
        foreach ($translations as $key => $translation) {
            $translationsArr[$key] = [
                'title' => $translation->getTitle(),
            ];
        }

        return $translationsArr;
    }
}
