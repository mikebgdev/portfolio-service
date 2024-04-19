<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\WorkExperience;
use App\Entity\WorkExperienceTranslation;
use App\Service\WorkExperienceService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

#[covers(WorkExperienceService::class)]
final class WorkExperienceServiceTest extends TestCase
{
    public function testBuildWorkExperienceWithNoResults(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $workExperienceService = new WorkExperienceService($entityManager);

        $result = $workExperienceService->buildWorkExperience();

        self::assertNull($result);
    }

    public function testBuildWorkExperienceWithResults(): void
    {
        $workExperience1 = new WorkExperience();
        $workExperience2 = new WorkExperience();

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([$workExperience1, $workExperience2]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $workExperienceService = new WorkExperienceService($entityManager);

        $result = $workExperienceService->buildWorkExperience();

        self::assertCount(2, $result);
    }

    public function testMapWorkExperience(): void
    {
        $workExperience = new WorkExperience();
        $workExperience->setCompany('Company A');
        $workExperience->setStartDate(new \DateTime('2020-01-01'));
        $workExperience->setEndDate(new \DateTime('2021-01-01'));
        $workExperience->addTranslation($this->createTranslation('Title A', 'Description A', 'en'));
        $workExperience->addTranslation($this->createTranslation('Title B', 'Description B', 'es'));

        $service = new WorkExperienceService($this->createEntityManagerMock([$workExperience]));

        $result = $service->mapWorkExperience($workExperience);

        $expectedResult = [
            'company' => 'Company A',
            'startDate' => new \DateTime('2020-01-01'),
            'endDate' => new \DateTime('2021-01-01'),
            'translations' => [
                'en' => ['title' => 'Title A', 'description' => 'Description A'],
                'es' => ['title' => 'Title B', 'description' => 'Description B'],
            ],
        ];

        self::assertEquals($expectedResult, $result);
    }

    public function testMapTranslations(): void
    {
        $translation1 = $this->createTranslation('Title 1', 'Description 1', 'en');
        $translation2 = $this->createTranslation('Title 2', 'Description 2', 'es');

        $service = new WorkExperienceService($this->createEntityManagerMock([$translation1, $translation2]));
        $mappedTranslations = $service->mapTranslations([$translation1, $translation2]);

        $expectedResult = [
            ['title' => 'Title 1', 'description' => 'Description 1'],
            ['title' => 'Title 2', 'description' => 'Description 2'],
        ];

        self::assertEquals($expectedResult, $mappedTranslations);
    }

    private function createTranslation(string $title, string $description, string $locale): WorkExperienceTranslation
    {
        $translation = new WorkExperienceTranslation();
        $translation->setTitle($title);
        $translation->setLocale($locale);
        $translation->setDescription($description);

        return $translation;
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
