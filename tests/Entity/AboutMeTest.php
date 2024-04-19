<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Tests\Entity;

use App\Entity\AboutMe;
use PHPUnit\Framework\TestCase;

#[covers(AboutMe::class)]
final class AboutMeTest extends TestCase
{
    public function testSetName()
    {
        $aboutMe = new AboutMe();
        $aboutMe->setName('John Doe');

        self::assertEquals('John Doe', $aboutMe->getName());
    }

    public function testSetAge()
    {
        $aboutMe = new AboutMe();
        $aboutMe->setAge(30);

        self::assertEquals(30, $aboutMe->getAge());
    }

    public function testSetEmail()
    {
        $aboutMe = new AboutMe();
        $aboutMe->setEmail('john@example.com');

        self::assertEquals('john@example.com', $aboutMe->getEmail());
    }

    public function testSetLocation()
    {
        $aboutMe = new AboutMe();
        $aboutMe->setLocation('New York');

        self::assertEquals('New York', $aboutMe->getLocation());
    }

    public function testSetPhotoPath()
    {
        $aboutMe = new AboutMe();
        $aboutMe->setPhotoPath('/path/to/photo.jpg');

        self::assertEquals('/path/to/photo.jpg', $aboutMe->getPhotoPath());
    }

    public function testSetCurriculumPath()
    {
        $aboutMe = new AboutMe();
        $aboutMe->setCurriculumPath('/path/to/resume.pdf');

        self::assertEquals('/path/to/resume.pdf', $aboutMe->getCurriculumPath());
    }

    public function testPropertiesAreNullable()
    {
        $aboutMe = new AboutMe();

        self::assertNull($aboutMe->getId());
        self::assertNull($aboutMe->getName());
        self::assertNull($aboutMe->getAge());
        self::assertNull($aboutMe->getEmail());
        self::assertNull($aboutMe->getLocation());
        self::assertNull($aboutMe->getPhotoPath());
        self::assertNull($aboutMe->getCurriculumPath());
    }

    public function testToString()
    {
        $aboutMe = new AboutMe();
        $aboutMe->setName('John Doe');

        self::assertEquals('John Doe', $aboutMe->toString());
    }
}
