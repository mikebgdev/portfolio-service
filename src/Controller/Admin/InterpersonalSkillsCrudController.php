<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Controller\Admin;

use App\EasyAdmin\Field\TranslationsField;
use App\Entity\InterpersonalSkills;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class InterpersonalSkillsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InterpersonalSkills::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setEntityLabelInSingular('Interpersonal Skill')
            ->setEntityLabelInPlural('Interpersonal Skills')
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
        yield CodeEditorField::new('svg')
            ->setLabel('SVG');
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->leftJoin('entity.translations', 'et')
            ->addSelect('et');

        return $qb;
    }
}
