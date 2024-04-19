<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\AboutMe;
use App\Entity\AboutMeTranslation;
use App\Service\AboutMeService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[covers(AboutMeService::class)]
final class AboutMeServiceTest extends TestCase
{
    public function testBuildAboutMeNoResults()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $parameterBag = $this->createMock(ParameterBagInterface::class);

        $entityManager->method('getRepository')->willReturn($this->createRepositoryStub([]));

        $aboutMeService = new AboutMeService($entityManager, $parameterBag);

        $result = $aboutMeService->buildAboutMe();

        $expectedResult = null;
        self::assertEquals($expectedResult, $result);
    }

    public function testBuildAboutMeAllNull()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $parameterBag = $this->createMock(ParameterBagInterface::class);

        $aboutMe = new AboutMe();

        $entityManager->method('getRepository')->willReturn($this->createRepositoryStub([$aboutMe]));

        $parameterBag->method('get')->willReturnMap([
            ['upload_photo_directory', '/path/to/photo'],
            ['upload_curriculum_directory', '/path/to/curriculum'],
        ]);

        $aboutMeService = new AboutMeService($entityManager, $parameterBag);

        $result = $aboutMeService->buildAboutMe();

        $expectedResult = [
            'name' => null,
            'age' => null,
            'email' => null,
            'location' => null,
            'photo' => null,
            'curriculum' => null,
            'translations' => [],
        ];
        self::assertEquals($expectedResult, $result);
    }

    public function testBuildAboutMe()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $parameterBag = $this->createMock(ParameterBagInterface::class);

        $aboutMe = new AboutMe();
        $aboutMe->setName('John Doe');
        $aboutMe->setAge(30);
        $aboutMe->setEmail('john@example.com');
        $aboutMe->setLocation('New York');
        $aboutMe->setPhotoPath('photo.jpg');
        $aboutMe->setCurriculumPath('resume.pdf');

        $entityManager->method('getRepository')->willReturn($this->createRepositoryStub([$aboutMe]));

        $parameterBag->method('get')->willReturnMap([
            ['upload_photo_directory', '/path/to/photo'],
            ['upload_curriculum_directory', '/path/to/curriculum'],
        ]);

        $aboutMeService = new AboutMeService($entityManager, $parameterBag);

        $result = $aboutMeService->buildAboutMe();

        $expectedResult = [
            'name' => 'John Doe',
            'age' => 30,
            'email' => 'john@example.com',
            'location' => 'New York',
            'photo' => '/path/to/photo/photo.jpg',
            'curriculum' => '/path/to/curriculum/resume.pdf',
            'translations' => [],
        ];
        self::assertEquals($expectedResult, $result);
    }

    public function testMapTranslations()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $parameterBag = $this->createMock(ParameterBagInterface::class);

        $translation1 = new AboutMeTranslation();
        $translation1->setNationality('Spanish');
        $translation1->setParagraph1('Lorem ipsum dolor sit amet');
        $translation1->setParagraph2('Consectetur adipiscing elit');

        $translation2 = new AboutMeTranslation();
        $translation2->setNationality('English');
        $translation2->setParagraph1('Lorem ipsum dolor sit amet');
        $translation2->setParagraph2('Consectetur adipiscing elit');

        $aboutMeService = new AboutMeService($entityManager, $parameterBag);
        $mappedTranslations = $aboutMeService->mapTranslations([$translation1, $translation2]);

        $expectedResult = [
            0 => [
                'nationality' => 'Spanish',
                'paragraph1' => 'Lorem ipsum dolor sit amet',
                'paragraph2' => 'Consectetur adipiscing elit',
            ],
            1 => [
                'nationality' => 'English',
                'paragraph1' => 'Lorem ipsum dolor sit amet',
                'paragraph2' => 'Consectetur adipiscing elit',
            ],
        ];
        self::assertEquals($expectedResult, $mappedTranslations);
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
