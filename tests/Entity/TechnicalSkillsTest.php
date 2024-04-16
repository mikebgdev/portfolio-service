<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Tests\Entity;

use App\Entity\TechnicalSkills;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \App\Entity\TechnicalSkills
 */
class TechnicalSkillsTest extends TestCase
{
    public function testId(): void
    {
        $technicalSkills = new TechnicalSkills();

        self::assertNull($technicalSkills->getId());
    }

    public function testTitle(): void
    {
        $technicalSkills = new TechnicalSkills();
        $title = 'Test Title';

        $technicalSkills->setTitle($title);

        self::assertEquals($title, $technicalSkills->getTitle());
    }

    public function testSvg(): void
    {
        $technicalSkills = new TechnicalSkills();
        $svg = '<svg>...</svg>';

        $technicalSkills->setSvg($svg);

        self::assertEquals($svg, $technicalSkills->getSvg());
    }
}
