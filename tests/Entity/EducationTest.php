<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Education;
use App\Entity\EducationTranslation;
use PHPUnit\Framework\TestCase;

#[covers(Education::class)]
final class EducationTest extends TestCase
{
    public function testGetSetStartDate()
    {
        $education = new Education();
        $startDate = new \DateTime('2022-01-01');
        $education->setStartDate($startDate);

        self::assertEquals($startDate, $education->getStartDate());
    }

    public function testGetSetEndDate()
    {
        $education = new Education();
        $endDate = new \DateTime('2022-12-31');
        $education->setEndDate($endDate);

        self::assertEquals($endDate, $education->getEndDate());
    }

    public function testGetTitleTranslation()
    {
        $education = new Education();

        $translation = new EducationTranslation();
        $translation->setLocale('en');
        $translation->setTitle('Computer Science');

        $education->addTranslation($translation);

        self::assertEquals('Computer Science', $education->getTitleTranslation());
    }

    public function testGetEducationalCenterTranslation()
    {
        $education = new Education();

        $translation = new EducationTranslation();
        $translation->setLocale('en');
        $translation->setEducationalCenter('University of Computer Science');

        $education->addTranslation($translation);

        self::assertEquals('University of Computer Science', $education->getEducationalCenterTranslation());
    }

    public function testPropertiesAreNullable()
    {
        $education = new Education();

        self::assertNull($education->getId());
        self::assertNull($education->getStartDate());
        self::assertNull($education->getEndDate());
    }
}
