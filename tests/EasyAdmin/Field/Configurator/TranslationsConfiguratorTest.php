<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\EasyAdmin\Field\Configurator;

use App\EasyAdmin\Field\Configurator\TranslationsConfigurator;
use App\EasyAdmin\Field\TranslationsField;
use App\Entity\Categories;
use Doctrine\ORM\Mapping\ClassMetadata;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use PHPUnit\Framework\TestCase;

#[covers(TranslationsConfigurator::class)]
final class TranslationsConfiguratorTest extends TestCase
{
    private TranslationsConfigurator $configurator;
    private FieldDto $fieldDto;
    private EntityDto $entityDto;
    private AdminContext $context;

    protected function setUp(): void
    {
        $fieldConfigurator1 = $this->createMock(FieldConfiguratorInterface::class);
        $fieldConfigurator2 = $this->createMock(FieldConfiguratorInterface::class);

        $this->configurator = new TranslationsConfigurator([$fieldConfigurator1, $fieldConfigurator2]);
        $this->fieldDto = new FieldDto();
        $this->fieldDto->setFieldFqcn(TranslationsField::class);
        $this->fieldDto->setCustomOption(TranslationsField::OPTION_FIELDS_CONFIG, ['field1', 'field2']);

        $this->entityDto = new EntityDto('App\Entity\Categories', new ClassMetadata(Categories::class));
    }

    public function testConstructor(): void
    {
        $reflection = new \ReflectionClass(TranslationsConfigurator::class);
        $property = $reflection->getProperty('fieldConfigurators');

        $configuredFieldConfigurators = $property->getValue($this->configurator);
        self::assertIsArray($configuredFieldConfigurators);
        self::assertCount(2, $configuredFieldConfigurators);
    }

    public function testSupports(): void
    {
        self::assertTrue($this->configurator->supports($this->fieldDto, $this->entityDto));
    }

    public function testSupportsNotTranslations(): void
    {
        $fieldDtoNonTranslations = new FieldDto();
        $fieldDtoNonTranslations->setFieldFqcn('NonTranslationsField');

        self::assertFalse($this->configurator->supports($fieldDtoNonTranslations, $this->entityDto));
    }

    public function testBuildFieldsCollection(): void
    {
        $result = $this->configurator->buildFieldsCollection($this->fieldDto);

        self::assertInstanceOf(FieldCollection::class, $result);
        self::assertCount(2, $result);
    }
}
