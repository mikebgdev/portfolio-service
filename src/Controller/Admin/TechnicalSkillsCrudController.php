<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\TechnicalSkills;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TechnicalSkillsCrudController extends AbstractCrudController
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
            ->setEntityLabelInPlural('Technical Skill')
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
