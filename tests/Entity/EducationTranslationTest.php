<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\EducationTranslation;
use PHPUnit\Framework\TestCase;

#[covers(EducationTranslation::class)]
final class EducationTranslationTest extends TestCase
{
    public function testGetSetTitle()
    {
        $translation = new EducationTranslation();
        $translation->setTitle('Computer Science');

        self::assertEquals('Computer Science', $translation->getTitle());
    }

    public function testGetSetEducationalCenter()
    {
        $translation = new EducationTranslation();
        $translation->setEducationalCenter('University of Computer Science');

        self::assertEquals('University of Computer Science', $translation->getEducationalCenter());
    }

    public function testPropertiesAreNullable()
    {
        $translation = new EducationTranslation();

        self::assertNull($translation->getTitle());
        self::assertNull($translation->getEducationalCenter());
    }
}
