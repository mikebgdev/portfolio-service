<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Hero;
use App\Entity\HeroTranslation;
use PHPUnit\Framework\TestCase;

#[covers(Hero::class)]
final class HeroTest extends TestCase
{
    public function testGetSetTitleTranslation()
    {
        $hero = new Hero();
        $translation = new HeroTranslation();

        $translation->setLocale('en');
        $translation->setTitle('Superhero');
        $hero->addTranslation($translation);

        self::assertEquals('Superhero', $hero->getTitleTranslation());
    }

    public function testPropertiesAreNullable()
    {
        $hero = new Hero();

        self::assertNull($hero->getId());
    }
}
