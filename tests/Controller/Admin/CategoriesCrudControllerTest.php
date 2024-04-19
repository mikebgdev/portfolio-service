<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\CategoriesCrudController;
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
use Symfony\Component\HttpFoundation\Request;

#[covers(CategoriesCrudController::class)]
final class CategoriesCrudControllerTest extends TestCase
{
    public function testGetEntityFqcnReturnsCorrectClass()
    {
        $controller = new CategoriesCrudController();

        $fqcn = $controller::getEntityFqcn();

        self::assertEquals('App\Entity\Categories', $fqcn);
    }

    public function testConfigureCrudReturnsCrudObject()
    {
        $controller = new CategoriesCrudController();

        $crud = $controller->configureCrud(Crud::new());

        self::assertInstanceOf(Crud::class, $crud);
    }

    public function testConfigureFieldsReturnsIterable()
    {
        $controller = new CategoriesCrudController();

        $fields = $controller->configureFields('edit');
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

        $controller = new CategoriesCrudController();
        $controller->setContainer($container);

        $searchDto = new SearchDto(new Request([['']]), [], '', [], [], []);
        $entityDto = new EntityDto('App\Entity\Categories', new ClassMetadata(Categories::class));
        $fields = FieldCollection::new([]);
        $filters = FilterCollection::new();

        $qb = $controller->createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        self::assertInstanceOf(QueryBuilder::class, $qb);
    }
}
