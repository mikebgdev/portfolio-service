<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Education;
use App\Entity\EducationTranslation;
use App\Service\EducationService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

#[covers(EducationService::class)]
final class EducationServiceTest extends TestCase
{
    public function testBuildEducationWithNoResults(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $educationService = new EducationService($entityManager);

        $result = $educationService->buildEducation();

        self::assertNull($result);
    }

    public function testBuildEducationWithEmptyTranslations(): void
    {
        $education = new Education();

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([$education]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $educationService = new EducationService($entityManager);

        $result = $educationService->buildEducation();

        $expectedResult = [
            [
                'startDate' => null,
                'endDate' => null,
                'translations' => [],
            ],
        ];

        self::assertEquals($expectedResult, $result);
    }

    public function testBuildEducationWithTranslations(): void
    {
        $education = new Education();
        $translation1 = new EducationTranslation();
        $translation1->setTitle('Bachelor of Science');
        $translation1->setEducationalCenter('University A');
        $translation1->setLocale('en');
        $education->addTranslation($translation1);

        $translation2 = new EducationTranslation();
        $translation2->setTitle('Master of Arts');
        $translation2->setEducationalCenter('University B');
        $translation2->setLocale('es');
        $education->addTranslation($translation2);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([$education]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $educationService = new EducationService($entityManager);

        $result = $educationService->buildEducation();

        $expectedResult = [
            [
                'startDate' => null,
                'endDate' => null,
                'translations' => [
                    'en' => [
                        'title' => 'Bachelor of Science',
                        'educationalCenter' => 'University A',
                    ],
                    'es' => [
                        'title' => 'Master of Arts',
                        'educationalCenter' => 'University B',
                    ],
                ],
            ],
        ];

        self::assertEquals($expectedResult, $result);
    }

    public function testMapWorkExperience()
    {
        $education = new Education();
        $education->setStartDate(new \DateTime('2022-01-01'));
        $education->setEndDate(new \DateTime('2022-12-31'));

        $translation1 = new EducationTranslation();
        $translation1->setTitle('Bachelor of Science');
        $translation1->setLocale('en');
        $translation1->setEducationalCenter('University A');

        $translation2 = new EducationTranslation();
        $translation2->setTitle('Master of Arts');
        $translation2->setLocale('es');
        $translation2->setEducationalCenter('University B');

        $translations = new ArrayCollection([$translation1, $translation2]);

        $education->setTranslations($translations);

        $service = new EducationService($this->createEntityManagerMock([$translation1, $translation2]));

        $result = $service->mapWorkExperience($education);

        $expectedResult = [
            'startDate' => new \DateTime('2022-01-01'),
            'endDate' => new \DateTime('2022-12-31'),
            'translations' => [
                'en' => [
                    'title' => 'Bachelor of Science',
                    'educationalCenter' => 'University A',
                ],
                'es' => [
                    'title' => 'Master of Arts',
                    'educationalCenter' => 'University B',
                ],
            ],
        ];

        self::assertEquals($expectedResult, $result);
    }

    public function testMapTranslations()
    {
        $translation1 = new EducationTranslation();
        $translation1->setTitle('Computer Science');
        $translation1->setEducationalCenter('University of Example');

        $translation2 = new EducationTranslation();
        $translation2->setTitle('Physics');
        $translation2->setEducationalCenter('College of Example');

        $service = new EducationService($this->createEntityManagerMock([$translation1, $translation2]));
        $mappedTranslations = $service->mapTranslations([$translation1, $translation2]);

        $expectedResult = [
            0 => [
                'title' => 'Computer Science',
                'educationalCenter' => 'University of Example',
            ],
            1 => [
                'title' => 'Physics',
                'educationalCenter' => 'College of Example',
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
