<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Categories;
use App\Entity\CategoriesTranslation;
use App\Entity\TechnicalSkills;
use App\Service\TechnicalSkillsService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

#[covers(TechnicalSkillsService::class)]
final class TechnicalSkillsServiceTest extends TestCase
{
    public function testBuildTechnicalSkillsWithNoResults(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $technicalSkillsService = new TechnicalSkillsService($entityManager);

        $result = $technicalSkillsService->buildTechnicalSkills();

        self::assertNull($result);
    }

    public function testBuildTechnicalSkillsWithResults(): void
    {
        $category1 = new Categories();
        $category2 = new Categories();

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([$category1, $category2]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $technicalSkillsService = new TechnicalSkillsService($entityManager);

        $result = $technicalSkillsService->buildTechnicalSkills();

        self::assertCount(2, $result);
    }

    public function testMapCategories(): void
    {
        $category = new Categories();
        $category->addTranslation($this->createTranslation('Category Title 1', 'en'));
        $category->addTechnicalSkill($this->createTechnicalSkill('Skill Title 1', 'skill1.svg'));
        $category->addTechnicalSkill($this->createTechnicalSkill('Skill Title 2', 'skill2.svg'));

        $service = new TechnicalSkillsService($this->createEntityManagerMock([$category]));

        $result = $service->mapCategories($category);

        $expectedResult = [
            'translations' => [
                'en' => ['title' => 'Category Title 1'],
            ],
            'technicalSkills' => [
                ['title' => 'Skill Title 1', 'svg' => 'skill1.svg'],
                ['title' => 'Skill Title 2', 'svg' => 'skill2.svg'],
            ],
        ];

        self::assertEquals($expectedResult, $result);
    }

    public function testMapTranslations(): void
    {
        $translation1 = $this->createTranslation('Translation 1', 'en');
        $translation2 = $this->createTranslation('Translation 2', 'es');

        $service = new TechnicalSkillsService($this->createEntityManagerMock([$translation1, $translation2]));
        $mappedTranslations = $service->mapTranslations([$translation1, $translation2]);

        $expectedResult = [
            ['title' => 'Translation 1'],
            ['title' => 'Translation 2'],
        ];

        self::assertEquals($expectedResult, $mappedTranslations);
    }

    public function testMapTechnicalSkills(): void
    {
        $technicalSkill1 = $this->createTechnicalSkill('Skill Title 1', 'skill1.svg');
        $technicalSkill2 = $this->createTechnicalSkill('Skill Title 2', 'skill2.svg');

        $service = new TechnicalSkillsService($this->createEntityManagerMock([$technicalSkill1, $technicalSkill2]));
        $mappedTechnicalSkills = $service->mapTechnicalSkills([$technicalSkill1, $technicalSkill2]);

        $expectedResult = [
            ['title' => 'Skill Title 1', 'svg' => 'skill1.svg'],
            ['title' => 'Skill Title 2', 'svg' => 'skill2.svg'],
        ];

        self::assertEquals($expectedResult, $mappedTechnicalSkills);
    }

    private function createTranslation(string $title, string $locale): CategoriesTranslation
    {
        $translation = new CategoriesTranslation();
        $translation->setTitle($title);
        $translation->setLocale($locale);

        return $translation;
    }

    private function createTechnicalSkill(string $title, string $svg): TechnicalSkills
    {
        $technicalSkill = new TechnicalSkills();
        $technicalSkill->setTitle($title);
        $technicalSkill->setSvg($svg);

        return $technicalSkill;
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
