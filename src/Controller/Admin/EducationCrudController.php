<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Controller\Admin;

use App\EasyAdmin\Field\TranslationsField;
use App\Entity\Education;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class EducationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Education::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setEntityLabelInSingular('Education')
            ->setEntityLabelInPlural('Educations')
            ->renderContentMaximized();
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titleTranslation')
            ->setLabel('Title')
            ->hideOnForm();
        yield TextField::new('educationalCenterTranslation')
            ->setLabel('Educational Center')
            ->hideOnForm();

        yield FormField::addFieldset('General');
        yield DateField::new('startDate')
            ->setLabel('Start Date');
        yield DateField::new('endDate')
            ->setLabel('End Date');

        yield FormField::addFieldset('Translations')
            ->setIcon('language');
        yield TranslationsField::new('translations')
            ->addTranslatableField(
                TextField::new('title')
                    ->setLabel('Title')
                    ->setRequired(true)
            )
            ->addTranslatableField(
                TextField::new('educationalCenter')
                    ->setLabel('Educational Center')
            );
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
