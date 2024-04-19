<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\InterpersonalSkills;
use App\Entity\InterpersonalSkillsTranslation;
use App\Service\InterpersonalSkillsService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

#[covers(InterpersonalSkillsService::class)]
final class InterpersonalSkillsServiceTest extends TestCase
{
    public function testBuildInterpersonalSkillsWithNoResults(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $interpersonalSkillsService = new InterpersonalSkillsService($entityManager);

        $result = $interpersonalSkillsService->buildInterpersonalSkills();

        self::assertNull($result);
    }

    public function testBuildInterpersonalSkillsWithResults(): void
    {
        $interpersonalSkill1 = new InterpersonalSkills();
        $interpersonalSkill2 = new InterpersonalSkills();

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([$interpersonalSkill1, $interpersonalSkill2]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $interpersonalSkillsService = new InterpersonalSkillsService($entityManager);

        $result = $interpersonalSkillsService->buildInterpersonalSkills();

        self::assertCount(2, $result);
    }

    public function testMapInterpersonalSkills(): void
    {
        $interpersonalSkill = new InterpersonalSkills();
        $interpersonalSkill->setSvg('icon.svg');

        $translation1 = new InterpersonalSkillsTranslation();
        $translation1->setLocale('en');
        $translation1->setTitle('Communication');

        $translation2 = new InterpersonalSkillsTranslation();
        $translation2->setLocale('es');
        $translation2->setTitle('Teamwork');

        $translations = new ArrayCollection([$translation1, $translation2]);

        $interpersonalSkill->setTranslations($translations);

        $service = new InterpersonalSkillsService($this->createEntityManagerMock([$translation1, $translation2]));

        $result = $service->mapInterpersonalSkills($interpersonalSkill);

        $expectedResult = [
            'svg' => 'icon.svg',
            'translations' => [
                'en' => [
                    'title' => 'Communication',
                ],
                'es' => [
                    'title' => 'Teamwork',
                ],
            ],
        ];

        self::assertEquals($expectedResult, $result);
    }

    public function testMapTranslations(): void
    {
        $translation1 = new InterpersonalSkillsTranslation();
        $translation1->setLocale('en');
        $translation1->setTitle('Communication');

        $translation2 = new InterpersonalSkillsTranslation();
        $translation2->setLocale('es');
        $translation2->setTitle('Teamwork');

        $service = new InterpersonalSkillsService($this->createEntityManagerMock([$translation1, $translation2]));
        $mappedTranslations = $service->mapTranslations([$translation1, $translation2]);

        $expectedResult = [
            [
                'title' => 'Communication',
            ],
            [
                'title' => 'Teamwork',
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
