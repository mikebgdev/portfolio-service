<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\EasyAdmin\Field;

use App\EasyAdmin\Field\TranslationsField;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use PHPUnit\Framework\TestCase;

#[covers(TranslationsField::class)]
final class TranslationsFieldTest extends TestCase
{
    public function testNewTranslationsField()
    {
        $field = TranslationsField::new('translations', 'Translations');

        self::assertInstanceOf(TranslationsField::class, $field);
        self::assertInstanceOf(FieldInterface::class, $field);
    }

    public function testAddTranslatableField()
    {
        $field = TranslationsField::new('translations', 'Translations');
        $field1 = TranslationsField::new('field1', 'Field 1');
        $field2 = TranslationsField::new('field2', 'Field 2');

        $field->addTranslatableField($field1);
        $field->addTranslatableField($field2);

        $fieldsConfig = $field->getAsDto()->getCustomOption(TranslationsField::OPTION_FIELDS_CONFIG);

        self::assertCount(2, $fieldsConfig);
        self::assertContains($field1, $fieldsConfig);
        self::assertContains($field2, $fieldsConfig);
    }
}
