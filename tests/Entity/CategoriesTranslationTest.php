<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\CategoriesTranslation;
use PHPUnit\Framework\TestCase;

#[covers(CategoriesTranslation::class)]
final class CategoriesTranslationTest extends TestCase
{
    public function testSetAndGetTitle()
    {
        $translation = new CategoriesTranslation();
        $translation->setTitle('Technology');

        self::assertEquals('Technology', $translation->getTitle());
    }

    public function testTitleIsNullable()
    {
        $translation = new CategoriesTranslation();

        self::assertNull($translation->getTitle());
    }
}
