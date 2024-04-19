<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\DashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use PHPUnit\Framework\TestCase;

#[covers(DashboardController::class)]
final class DashboardControllerTest extends TestCase
{
    public function testConfigureDashboard(): void
    {
        $controller = new DashboardController();

        $dashboard = $controller->configureDashboard();
        self::assertInstanceOf(Dashboard::class, $dashboard);

        self::assertEquals('Api Portfolio Symfony', $dashboard->getAsDto()->getTitle());
        self::assertEquals('icon-dev-logo.png', $dashboard->getAsDto()->getFaviconPath());
    }

    public function testConfigureCrudReturnsCrudObject()
    {
        $controller = new DashboardController();

        $crud = $controller->configureCrud(Crud::new());

        self::assertInstanceOf(Crud::class, $crud);
    }

    public function testConfigureFieldsReturnsIterable()
    {
        $controller = new DashboardController();

        $fields = $controller->configureMenuItems();
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
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
        $fields->next();
        self::assertInstanceOf(\Generator::class, $fields);
    }
}
