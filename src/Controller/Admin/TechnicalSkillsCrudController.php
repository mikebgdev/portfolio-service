<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Controller\Admin;

use App\Entity\TechnicalSkills;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class TechnicalSkillsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TechnicalSkills::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setEntityLabelInSingular('Technical Skill')
            ->setEntityLabelInPlural('Technical Skills')
            ->renderContentMaximized();
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title')
            ->setLabel('Title');
        yield AssociationField::new('category')
            ->setLabel('Category');
        yield CodeEditorField::new('svg')
            ->setLabel('SVG');
    }
}
