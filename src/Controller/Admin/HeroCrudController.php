<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Controller\Admin;

use App\EasyAdmin\Field\TranslationsField;
use App\Entity\Hero;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeroCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hero::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setEntityLabelInSingular('Hero Item')
            ->setEntityLabelInPlural('Hero Items')
            ->renderContentMaximized();
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titleTranslation')
            ->setLabel('Title')
            ->hideOnForm();

        yield TranslationsField::new('translations')
            ->addTranslatableField(
                TextField::new('title')
                    ->setLabel('Title')
                    ->setRequired(true)
            );
    }
}
