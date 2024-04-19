<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\HeroTranslation;
use PHPUnit\Framework\TestCase;

#[covers(HeroTranslation::class)]
final class HeroTranslationTest extends TestCase
{
    public function testGetSetTitle()
    {
        $translation = new HeroTranslation();

        $translation->setTitle('Superhero');

        self::assertEquals('Superhero', $translation->getTitle());
    }

    public function testPropertiesAreNullable()
    {
        $translation = new HeroTranslation();

        self::assertNull($translation->getId());
        self::assertNull($translation->getTitle());
    }
}
