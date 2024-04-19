<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Hero;
use App\Entity\HeroTranslation;
use Doctrine\ORM\EntityManagerInterface;

final class HeroService
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function buildHero(): ?array
    {
        $heroItems = $this->manager->getRepository(Hero::class)->findAll();

        if (empty($heroItems)) {
            return null;
        }

        $heroItemsArr = [];

        /**
         * @var Hero $hero
         */
        foreach ($heroItems as $hero) {
            $heroItemsArr[] = $this->mapWorkExperience($hero);
        }

        return $heroItemsArr;
    }

    public function mapWorkExperience(Hero $hero): array
    {
        $translations = $this->mapTranslations($hero->getTranslations());

        return [
            'translations' => $translations,
        ];
    }

    public function mapTranslations($translations): array
    {
        $translationsArr = [];

        /**
         * @var HeroTranslation $translation
         */
        foreach ($translations as $key => $translation) {
            $translationsArr[$key] = [
                'title' => $translation->getTitle(),
            ];
        }

        return $translationsArr;
    }
}
