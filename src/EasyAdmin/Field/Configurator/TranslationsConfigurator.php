<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\EasyAdmin\Field\Configurator;

use App\EasyAdmin\Field\TranslationsField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use Symfony\Component\Validator\Constraints\Valid;

class TranslationsConfigurator implements FieldConfiguratorInterface
{
    public function __construct(private iterable $fieldConfigurators)
    {
    }

    public function supports(FieldDto $field, EntityDto $entityDto): bool
    {
        return TranslationsField::class === $field->getFieldFqcn();
    }

    public function configure(FieldDto $field, EntityDto $entityDto, AdminContext $context): void
    {
        $formTypeOptionsFields = $this->buildFormTypeOptionsFields($field, $entityDto, $context);

        $this->configureFormThemesAndAssets($field, $context);

        $field->setFormTypeOptions(
            [
                'ea_fields' => $this->buildFieldsCollection($field),
                'fields' => $formTypeOptionsFields,
                'constraints' => [
                    new Valid(),
                ],
            ]
        );
    }

    private function buildFormTypeOptionsFields(FieldDto $field, EntityDto $entityDto, AdminContext $context): array
    {
        $formTypeOptionsFields = [];
        $fieldsCollection = $this->buildFieldsCollection($field);

        foreach ($fieldsCollection as $dto) {
            /**
             * @var FieldDto $dto
             */
            foreach ($this->fieldConfigurators as $configurator) {
                if ($configurator->supports($dto, $entityDto)) {
                    $configurator->configure($dto, $entityDto, $context);
                }
            }

            $this->configureFormThemesAndAssets($dto, $context);

            $dto->setFormTypeOption('field_type', $dto->getFormType());
            $formTypeOptionsFields[$dto->getProperty()] = $dto->getFormTypeOptions();
        }

        return $formTypeOptionsFields;
    }

    public function buildFieldsCollection(FieldDto $field): FieldCollection
    {
        return FieldCollection::new((array) $field->getCustomOption(TranslationsField::OPTION_FIELDS_CONFIG));
    }

    private function configureFormThemesAndAssets(FieldDto $field, AdminContext $context): void
    {
        foreach ($field->getFormThemes() as $formThemePath) {
            $context?->getCrud()?->addFormTheme($formThemePath);
        }

        $context->getAssets()->mergeWith($field->getAssets());
    }
}
