<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\WorkExperience;
use App\Entity\WorkExperienceTranslation;
use PHPUnit\Framework\TestCase;

#[covers(WorkExperience::class)]
final class WorkExperienceTest extends TestCase
{
    public function testPropertiesAreNullable()
    {
        $workExperience = new WorkExperience();

        self::assertNull($workExperience->getId());
        self::assertNull($workExperience->getCompany());
        self::assertNull($workExperience->getStartDate());
        self::assertNull($workExperience->getEndDate());
    }

    public function testGetSetCompany()
    {
        $workExperience = new WorkExperience();

        $workExperience->setCompany('ABC Inc.');

        self::assertEquals('ABC Inc.', $workExperience->getCompany());
    }

    public function testGetSetStartDate()
    {
        $workExperience = new WorkExperience();
        $startDate = new \DateTime('2022-01-01');

        $workExperience->setStartDate($startDate);

        self::assertEquals($startDate, $workExperience->getStartDate());
    }

    public function testGetSetEndDate()
    {
        $workExperience = new WorkExperience();
        $endDate = new \DateTime('2022-12-31');

        $workExperience->setEndDate($endDate);

        self::assertEquals($endDate, $workExperience->getEndDate());
    }

    public function testGetTitleTranslation()
    {
        $education = new WorkExperience();

        $translation = new WorkExperienceTranslation();
        $translation->setLocale('en');
        $translation->setTitle('Software Engineer');

        $education->addTranslation($translation);

        self::assertEquals('Software Engineer', $education->getTitleTranslation());
    }
}
