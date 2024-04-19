<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Controller\Admin;

use App\Entity\SocialNetworks;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

final class SocialNetworksCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SocialNetworks::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setEntityLabelInSingular('Social Network')
            ->setEntityLabelInPlural('Social Networks')
            ->renderContentMaximized();
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title')
            ->setLabel('Title');
        yield UrlField::new('url')
            ->setLabel('Url');
        yield CodeEditorField::new('svg')
            ->setLabel('SVG');
    }
}
