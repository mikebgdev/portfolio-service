<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Hero;
use App\Entity\HeroTranslation;
use App\Service\HeroService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

#[covers(HeroService::class)]
final class HeroServiceTest extends TestCase
{
    public function testBuildHeroWithNoResults(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $heroService = new HeroService($entityManager);

        $result = $heroService->buildHero();

        self::assertNull($result);
    }

    public function testBuildHeroWithResults(): void
    {
        $hero1 = new Hero();
        $hero2 = new Hero();

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([$hero1, $hero2]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $heroService = new HeroService($entityManager);

        $result = $heroService->buildHero();

        self::assertCount(2, $result);
    }

    public function testMapWorkExperience(): void
    {
        $hero = new Hero();
        $translation1 = new HeroTranslation();
        $translation1->setLocale('es');
        $translation1->setTitle('Superman');

        $translation2 = new HeroTranslation();
        $translation2->setLocale('en');
        $translation2->setTitle('Batman');

        $translations = new ArrayCollection([$translation1, $translation2]);

        $hero->setTranslations($translations);

        $service = new HeroService($this->createEntityManagerMock([$translation1, $translation2]));

        $result = $service->mapWorkExperience($hero);

        $expectedResult = [
            'translations' => [
                'es' => [
                    'title' => 'Superman',
                ],
                'en' => [
                    'title' => 'Batman',
                ],
            ],
        ];

        self::assertEquals($expectedResult, $result);
    }

    public function testMapTranslations(): void
    {
        $translation1 = new HeroTranslation();
        $translation1->setTitle('Superman');

        $translation2 = new HeroTranslation();
        $translation2->setTitle('Batman');

        $service = new HeroService($this->createEntityManagerMock([$translation1, $translation2]));
        $mappedTranslations = $service->mapTranslations([$translation1, $translation2]);

        $expectedResult = [
            [
                'title' => 'Superman',
            ],
            [
                'title' => 'Batman',
            ],
        ];

        self::assertEquals($expectedResult, $mappedTranslations);
    }

    private function createEntityManagerMock(array $entities): EntityManagerInterface
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('getRepository')->willReturn($this->createRepositoryStub($entities));

        return $entityManager;
    }

    private function createRepositoryStub(array $entities): ObjectRepository
    {
        $repository = $this->createStub(ObjectRepository::class);
        $repository->method('findAll')->willReturn($entities);

        return $repository;
    }
}
