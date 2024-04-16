<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Form\Extension;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranslationsTypeExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [TranslationsType::class];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('ea_fields');
        $resolver->setAllowedTypes('ea_fields', FieldCollection::class);
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        /**
         * @var FieldCollection $fields
         */
        $fields = $options['ea_fields'];

        foreach ($view->children as $translationView) {
            foreach ($translationView->children as $fieldView) {
                $fieldView->vars['ea_crud_form'] = [
                    'ea_field' => $fields->getByProperty($fieldView->vars['name']),
                ];
            }
        }
    }
}
