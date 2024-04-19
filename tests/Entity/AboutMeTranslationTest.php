<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\AboutMeTranslation;
use PHPUnit\Framework\TestCase;

#[covers(AboutMeTranslation::class)]
final class AboutMeTranslationTest extends TestCase
{
    public function testSetAndGetNationality()
    {
        $translation = new AboutMeTranslation();
        $translation->setNationality('Spanish');

        self::assertEquals('Spanish', $translation->getNationality());
    }

    public function testSetAndGetParagraph1()
    {
        $translation = new AboutMeTranslation();
        $translation->setParagraph1('Lorem ipsum dolor sit amet');

        self::assertEquals('Lorem ipsum dolor sit amet', $translation->getParagraph1());
    }

    public function testSetAndGetParagraph2()
    {
        $translation = new AboutMeTranslation();
        $translation->setParagraph2('Consectetur adipiscing elit');

        self::assertEquals('Consectetur adipiscing elit', $translation->getParagraph2());
    }

    public function testPropertiesAreNullable()
    {
        $translation = new AboutMeTranslation();

        self::assertNull($translation->getNationality());
        self::assertNull($translation->getParagraph1());
        self::assertNull($translation->getParagraph2());
    }
}
