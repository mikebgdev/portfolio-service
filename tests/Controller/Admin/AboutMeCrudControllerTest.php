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
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[covers(AboutMeCrudController::class)]
final class AboutMeCrudControllerTest extends TestCase
{
    public function testGetEntityFqcnReturnsCorrectClass()
    {
        $controller = new AboutMeCrudController($this->createMock(ParameterBagInterface::class));

        $fqcn = $controller::getEntityFqcn();

        self::assertEquals('App\Entity\AboutMe', $fqcn);
    }

    public function testConfigureFieldsReturnsIterable()
    {
        $controller = new AboutMeCrudController($this->createMock(ParameterBagInterface::class));

        $fields = $controller->configureFields('edit');

        self::assertIsIterable($fields);
    }
}
