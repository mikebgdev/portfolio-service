<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Tests\Entity;

use App\Entity\Categories;
use App\Entity\TechnicalSkills;
use PHPUnit\Framework\TestCase;

#[covers(TechnicalSkills::class)]
final class TechnicalSkillsTest extends TestCase
{
    public function testPropertiesAreNullable()
    {
        $socialNetwork = new TechnicalSkills();

        self::assertNull($socialNetwork->getId());
        self::assertNull($socialNetwork->getTitle());
        self::assertNull($socialNetwork->getSvg());
    }

    public function testGetSetTitle()
    {
        $technicalSkill = new TechnicalSkills();

        $technicalSkill->setTitle('PHP');

        self::assertEquals('PHP', $technicalSkill->getTitle());
    }

    public function testGetSetSvg()
    {
        $technicalSkill = new TechnicalSkills();

        $technicalSkill->setSvg('<svg>...</svg>');

        self::assertEquals('<svg>...</svg>', $technicalSkill->getSvg());
    }

    public function testGetSetCategory()
    {
        $technicalSkill = new TechnicalSkills();
        $category = new Categories();

        $technicalSkill->setCategory($category);

        self::assertEquals($category, $technicalSkill->getCategory());
    }
}
