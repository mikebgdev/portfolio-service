<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\InterpersonalSkills;
use App\Entity\InterpersonalSkillsTranslation;
use PHPUnit\Framework\TestCase;

#[covers(InterpersonalSkills::class)]
final class InterpersonalSkillsTest extends TestCase
{
    public function testPropertiesAreNullable()
    {
        $skill = new InterpersonalSkills();

        self::assertNull($skill->getId());
        self::assertNull($skill->getSvg());
    }

    public function testGetSetSvg()
    {
        $skill = new InterpersonalSkills();

        $skill->setSvg('<svg>...</svg>');

        self::assertEquals('<svg>...</svg>', $skill->getSvg());
    }

    public function testGetTitleTranslation()
    {
        $skill = new InterpersonalSkills();

        $translation = new InterpersonalSkillsTranslation();
        $translation->setLocale('en');
        $translation->setTitle('Communication');

        $skill->addTranslation($translation);

        self::assertEquals('Communication', $skill->getTitleTranslation());
    }
}
