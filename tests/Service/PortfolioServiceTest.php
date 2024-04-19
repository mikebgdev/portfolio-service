<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\AboutMeService;
use App\Service\EducationService;
use App\Service\HeroService;
use App\Service\InterpersonalSkillsService;
use App\Service\PortfolioService;
use App\Service\ProjectsService;
use App\Service\SocialNetworksService;
use App\Service\TechnicalSkillsService;
use App\Service\WorkExperienceService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[covers(PortfolioService::class)]
final class PortfolioServiceTest extends TestCase
{
    private PortfolioService $portfolioService;

    protected function setUp(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $parameterBag = $this->createMock(ParameterBagInterface::class);

        $entityManager->method('getRepository')->willReturn($this->createRepositoryStub([]));

        $aboutMe = new AboutMeService($entityManager, $parameterBag);
        $educationService = new EducationService($entityManager);
        $heroService = new HeroService($entityManager);
        $interpersonalSkillsService = new InterpersonalSkillsService($entityManager);
        $socialNetworksService = new SocialNetworksService($entityManager);
        $technicalSkillsService = new TechnicalSkillsService($entityManager);
        $workExperienceService = new WorkExperienceService($entityManager);
        $projectsService = new ProjectsService($entityManager);

        $this->portfolioService = new PortfolioService(
            $aboutMe,
            $heroService,
            $technicalSkillsService,
            $interpersonalSkillsService,
            $projectsService,
            $workExperienceService,
            $educationService,
            $socialNetworksService
        );
    }

    public function testBuildPortfolioWithNoResults(): void
    {
        $result = $this->portfolioService->buildPortfolio();

        self::assertIsArray($result);
        self::assertNull($result['aboutMe']);
        self::assertNull($result['hero']);
        self::assertNull($result['technicalSkills']);
        self::assertNull($result['interpersonalSkills']);
        self::assertNull($result['projects']);
        self::assertNull($result['workExperience']);
        self::assertNull($result['education']);
        self::assertNull($result['socialNetworks']);
    }

    private function createRepositoryStub(array $entities): ObjectRepository
    {
        $repository = $this->createStub(ObjectRepository::class);
        $repository->method('findOneBy')->willReturnCallback(function ($criteria) use ($entities) {
            foreach ($entities as $entity) {
                if (empty($criteria)) {
                    return \reset($entities) ?: null;
                }
                foreach ($criteria as $key => $value) {
                    $getter = 'get'.\ucfirst($key);
                    if (\method_exists($entity, $getter) && $entity->{$getter}() === $value) {
                        return $entity;
                    }
                }
            }

            return null;
        });

        return $repository;
    }
}
