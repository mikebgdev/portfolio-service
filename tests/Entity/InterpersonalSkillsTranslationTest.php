<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\InterpersonalSkillsTranslation;
use PHPUnit\Framework\TestCase;

#[covers(InterpersonalSkillsTranslation::class)]
final class InterpersonalSkillsTranslationTest extends TestCase
{
    public function testPropertiesAreNullable()
    {
        $translation = new InterpersonalSkillsTranslation();

        self::assertNull($translation->getId());
        self::assertNull($translation->getTitle());
    }

    public function testGetSetTitle()
    {
        $translation = new InterpersonalSkillsTranslation();

        $translation->setTitle('Communication');

        self::assertEquals('Communication', $translation->getTitle());
    }
}
