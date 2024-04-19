<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Form\Extension;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Form\Extension\TranslationsTypeExtension;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

#[covers(TranslationsTypeExtension::class)]
final class TranslationsTypeExtensionTest extends TestCase
{
    public function testGetExtendedTypes(): void
    {
        $extension = new TranslationsTypeExtension();
        $extendedTypes = $extension::getExtendedTypes();

        self::assertContains(TranslationsType::class, $extendedTypes);
    }

    public function testConfigureOptions(): void
    {
        $resolver = new OptionsResolver();
        $extension = new TranslationsTypeExtension();

        $extension->configureOptions($resolver);

        self::assertTrue($resolver->isDefined('ea_fields'));
    }

    public function testFinishView(): void
    {
        $formView2 = new FormView();
        $formView2->vars['name'] = 'field1';

        $formView = new FormView();
        $formView->children['field1'] = new FormView();
        $formView->children['field1']->vars['name'] = 'field1';
        $formView->children['field1']->children[] = $formView2;

        $fieldCollection = FieldCollection::new([]);
        $fieldDto = new FieldDto();
        $fieldDto->setProperty('field1');
        $fieldCollection->add($fieldDto);

        $extension = new TranslationsTypeExtension();
        $extension->finishView($formView,
            $this->createMock(FormInterface::class),
            ['ea_fields' => $fieldCollection]);

        self::assertArrayHasKey('ea_crud_form', $formView->children['field1']->children[0]->vars);
        self::assertSame('field1', $formView->children['field1']->children[0]->vars['ea_crud_form']['ea_field']->getProperty());
    }
}
