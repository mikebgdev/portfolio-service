<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Categories;
use App\Entity\CategoriesTranslation;
use App\Entity\TechnicalSkills;
use PHPUnit\Framework\TestCase;

#[covers(Categories::class)]
final class CategoriesTest extends TestCase
{
    public function testAddAndRemoveTechnicalSkill()
    {
        $category = new Categories();
        $skill = new TechnicalSkills();

        $category->addTechnicalSkill($skill);
        self::assertTrue($category->getTechnicalSkills()->contains($skill));

        $category->removeTechnicalSkill($skill);
        self::assertFalse($category->getTechnicalSkills()->contains($skill));
    }

    public function testGetTitleTranslation()
    {
        $category = new Categories();

        $translation = new CategoriesTranslation();
        $translation->setLocale('en');
        $translation->setTitle('Tecnología');

        $category->addTranslation($translation);

        self::assertEquals('Tecnología', $category->getTitleTranslation());
    }

    public function testToString()
    {
        $category = new Categories();

        $translation = new CategoriesTranslation();
        $translation->setLocale('en');
        $translation->setTitle('Tecnología');

        $category->addTranslation($translation);

        self::assertEquals('Tecnología', $category->__toString());
    }

    public function testPropertiesAreNullable()
    {
        $aboutMe = new Categories();

        self::assertNull($aboutMe->getId());
    }
}
