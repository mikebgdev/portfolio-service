<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\SocialNetworks;
use App\Service\SocialNetworksService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

#[covers(SocialNetworksService::class)]
final class SocialNetworksServiceTest extends TestCase
{
    public function testBuildSocialNetworksWithNoResults(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $socialNetworksService = new SocialNetworksService($entityManager);

        $result = $socialNetworksService->buildSocialNetworks();

        self::assertNull($result);
    }

    public function testBuildSocialNetworksWithResults(): void
    {
        $socialNetwork1 = new SocialNetworks();
        $socialNetwork1->setTitle('Facebook');
        $socialNetwork1->setUrl('https://www.facebook.com');
        $socialNetwork1->setSvg('facebook.svg');

        $socialNetwork2 = new SocialNetworks();
        $socialNetwork2->setTitle('Twitter');
        $socialNetwork2->setUrl('https://twitter.com');
        $socialNetwork2->setSvg('twitter.svg');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(ObjectRepository::class);

        $repository->expects(self::once())
            ->method('findAll')
            ->willReturn([$socialNetwork1, $socialNetwork2]);

        $entityManager->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository);

        $socialNetworksService = new SocialNetworksService($entityManager);

        $result = $socialNetworksService->buildSocialNetworks();

        $expectedResult = [
            [
                'title' => 'Facebook',
                'url' => 'https://www.facebook.com',
                'svg' => 'facebook.svg',
            ],
            [
                'title' => 'Twitter',
                'url' => 'https://twitter.com',
                'svg' => 'twitter.svg',
            ],
        ];

        self::assertEquals($expectedResult, $result);
    }

    public function testMapSocialNetworks(): void
    {
        $socialNetwork = new SocialNetworks();
        $socialNetwork->setTitle('LinkedIn');
        $socialNetwork->setUrl('https://www.linkedin.com');
        $socialNetwork->setSvg('linkedin.svg');

        $service = new SocialNetworksService($this->createEntityManagerMock([$socialNetwork]));

        $result = $service->mapSocialNetworks($socialNetwork);

        $expectedResult = [
            'title' => 'LinkedIn',
            'url' => 'https://www.linkedin.com',
            'svg' => 'linkedin.svg',
        ];

        self::assertEquals($expectedResult, $result);
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
