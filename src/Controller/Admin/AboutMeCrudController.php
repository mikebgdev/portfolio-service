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
use App\Entity\AboutMe;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class AboutMeCrudController extends AbstractCrudController
{
    private ParameterBagInterface $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public static function getEntityFqcn(): string
    {
        return AboutMe::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->setEntityLabelInSingular(
                fn (?AboutMe $aboutMe, ?string $pageName) => $aboutMe ? $aboutMe->toString() : 'AboutMe'
            )
            ->setEntityLabelInPlural('AboutMe')
            ->renderContentMaximized();
    }

    public function configureFields(string $pageName): iterable
    {
        $pathDirPhoto = $this->params->get('upload_photo_directory');

        yield FormField::addTab('General');

        yield FormField::addFieldset('Details');
        yield TextField::new('name')
            ->setLabel('Name')
            ->setColumns(6);
        yield IntegerField::new('age')
            ->setLabel('Age')
            ->setColumns(6);
        yield EmailField::new('email')
            ->setLabel('Email')
            ->setColumns(6);
        yield TextField::new('location')
            ->setLabel('Location')
            ->setColumns(6);

        yield FormField::addFieldset('Files');
        yield ImageField::new('photoPath')
            ->setUploadDir('/public'.$pathDirPhoto)
            ->setBasePath($pathDirPhoto)
            ->setLabel('Photo')
            ->setColumns(6);
        yield TextField::new('curriculumPath')
            ->setFormType(FileUploadType::class)
            ->setLabel('CV')
            ->setColumns(6);

        yield FormField::addTab('Translations')
            ->setIcon('fa fa-language');
        yield TranslationsField::new('translations')
            ->addTranslatableField(
                TextField::new('nationality')
                    ->setLabel('Nationality')
                    ->setColumns(6)
            )
            ->addTranslatableField(
                TextEditorField::new('paragraph1')
                    ->setLabel('First Paragraph')
                    ->setNumOfRows(6)
            )
            ->addTranslatableField(
                TextEditorField::new('paragraph2')
                    ->setLabel('Second Paragraph')
                    ->setNumOfRows(6)
            );
    }
}
