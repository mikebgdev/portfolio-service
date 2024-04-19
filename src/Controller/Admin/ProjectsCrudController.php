<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Controller\Admin;

use App\EasyAdmin\Field\TranslationsField;
use App\Entity\Projects;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

final class ProjectsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Projects::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setEntityLabelInSingular('Project')
            ->setEntityLabelInPlural('Projects')
            ->renderContentMaximized();
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title')
            ->setLabel('Title');

        yield TranslationsField::new('translations')
            ->addTranslatableField(
                TextareaField::new('description')
                    ->setLabel('Description')
                    ->setRequired(true)
            );

        yield UrlField::new('urlDemo')
            ->setLabel('Url Demo');

        yield UrlField::new('urlGit')
            ->setLabel('Url Git');

        yield AssociationField::new('skills')
            ->setLabel('Technical Skills');
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
