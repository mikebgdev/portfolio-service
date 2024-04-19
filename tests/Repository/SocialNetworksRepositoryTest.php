<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Repository\SocialNetworksRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;

#[covers(SocialNetworksRepository::class)]
final class SocialNetworksRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $objectManager = $this->createMock(ObjectManager::class);

        $registry->method('getManagerForClass')->willReturn($objectManager);

        $repository = new SocialNetworksRepository($registry);
        self::assertNotNull($repository);
    }
}