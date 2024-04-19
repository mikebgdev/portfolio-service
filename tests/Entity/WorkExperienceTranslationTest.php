<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\WorkExperienceTranslation;
use PHPUnit\Framework\TestCase;

#[covers(WorkExperienceTranslation::class)]
final class WorkExperienceTranslationTest extends TestCase
{
    public function testPropertiesAreNullable()
    {
        $translation = new WorkExperienceTranslation();

        self::assertNull($translation->getId());
        self::assertNull($translation->getTitle());
        self::assertNull($translation->getDescription());
    }

    public function testGetSetTitle()
    {
        $translation = new WorkExperienceTranslation();

        $translation->setTitle('Software Engineer');

        self::assertEquals('Software Engineer', $translation->getTitle());
    }

    public function testGetSetDescription()
    {
        $translation = new WorkExperienceTranslation();

        $translation->setDescription('Developed web applications using PHP and Symfony framework');

        self::assertEquals('Developed web applications using PHP and Symfony framework', $translation->getDescription());
    }
}
