<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Projects;
use App\Entity\ProjectsTranslation;
use App\Entity\TechnicalSkills;
use App\Service\ProjectsService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

#[covers(ProjectsService::class)]
final class ProjectsServiceTest extends TestCase
{
    public function testBuildProjectsWithNoResults(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $projectService = new ProjectsService($entityManager);

        $result = $projectService->buildProjects();

        self::assertNull($result);
    }

    public function testBuildProjectsWithResults(): void
    {
        $project1 = new Projects();
        $project2 = new Projects();

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([$project1, $project2]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $projectService = new ProjectsService($entityManager);

        $result = $projectService->buildProjects();

        self::assertCount(2, $result);
    }

    public function testMapProjects(): void
    {
        $project1 = new Projects();
        $project1->setTitle('Portfolio');
        $project1->setUrlDemo('https://github.com/mikebgdev/Portfolio-Symfony');
        $project1->setUrlGit('https://github.com/mikebgdev/Portfolio-Symfony');
        $project1->addTranslation($this->createTranslation('Project Description 1', 'en'));
        $project1->addTechnicalSkill($this->createTechnicalSkill('Skill Title 1', 'skill1.svg'));
        $project1->addTechnicalSkill($this->createTechnicalSkill('Skill Title 2', 'skill2.svg'));

        $service = new ProjectsService($this->createEntityManagerMock([$project1]));

        $result = $service->mapProjects($project1);

        $expectedResult = [
            'title' => 'Portfolio',
            'urlDemo' => 'https://github.com/mikebgdev/Portfolio-Symfony',
            'urlGit' => 'https://github.com/mikebgdev/Portfolio-Symfony',
            'translations' => [
                'en' => ['description' => 'Project Description 1'],
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

        $service = new ProjectsService($this->createEntityManagerMock([$translation1, $translation2]));
        $mappedTranslations = $service->mapTranslations([$translation1, $translation2]);

        $expectedResult = [
            ['description' => 'Translation 1'],
            ['description' => 'Translation 2'],
        ];

        self::assertEquals($expectedResult, $mappedTranslations);
    }

    private function createTranslation(string $description, string $locale): ProjectsTranslation
    {
        $translation = new ProjectsTranslation();
        $translation->setDescription($description);
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
