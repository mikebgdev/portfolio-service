<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\AboutMeCrudController;
use App\Entity\Categories;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Orm\EntityRepositoryInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;

#[covers(AboutMeCrudController::class)]
final class AboutMeCrudControllerTest extends TestCase
{
    public function testGetEntityFqcnReturnsCorrectClass()
    {
        $parameterBag = $this->createMock(ParameterBagInterface::class);
        $controller = new AboutMeCrudController($parameterBag);

        $fqcn = $controller::getEntityFqcn();

        self::assertEquals('App\Entity\AboutMe', $fqcn);
    }

    public function testConfigureCrudReturnsCrudObject()
    {
        $parameterBag = $this->createMock(ParameterBagInterface::class);
        $controller = new AboutMeCrudController($parameterBag);

        $crud = $controller->configureCrud(Crud::new());

        self::assertInstanceOf(Crud::class, $crud);
    }

    public function testConfigureFieldsReturnsIterable()
    {
        $parameterBag = $this->createMock(ParameterBagInterface::class);
        $parameterBag
            ->method('get')
            ->with('upload_photo_directory')
            ->willReturn('/path');
        $controller = new AboutMeCrudController($parameterBag);

        $fields = $controller->configureFields('edit');
        self::assertInstanceOf(\Generator::class, $fields);
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
    }

    public function testCreateIndexQueryBuilderReturnsQueryBuilder()
    {
        $repositoryMock = $this->createMock(EntityRepositoryInterface::class);
        $container = $this->createMock(ContainerInterface::class);
        $container->expects(self::once())
            ->method('get')
            ->with(EntityRepository::class)
            ->willReturn($repositoryMock);

        $parameterBag = $this->createMock(ParameterBagInterface::class);
        $controller = new AboutMeCrudController($parameterBag);
        $controller->setContainer($container);

        $searchDto = new SearchDto(new Request([['']]), [], '', [], [], []);
        $entityDto = new EntityDto('App\Entity\AboutMe', new ClassMetadata(Categories::class));
        $fields = FieldCollection::new([]);
        $filters = FilterCollection::new();

        $qb = $controller->createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        self::assertInstanceOf(QueryBuilder::class, $qb);
    }
}
