<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Controller\Api;

use App\Controller\Api\PortfolioController;
use App\Service\PortfolioService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[covers(PortfolioController::class)]
final class PortfolioControllerTest extends TestCase
{
    private $entityManager;
    private $portfolioService;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->portfolioService = $this->createMock(PortfolioService::class);
    }

    public function testGetPortfolioReturnsJsonResponse(): void
    {
        $this->portfolioService->expects(self::once())
            ->method('buildPortfolio')
            ->willReturn([]);

        $controller = new PortfolioController();
        $response = $controller->getPortfolio($this->portfolioService, $this->entityManager);

        self::assertInstanceOf(JsonResponse::class, $response);
    }

    public function testGetPortfolioThrowsExceptionWhenPortfolioServiceThrowsException(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $this->portfolioService->expects(self::once())
            ->method('buildPortfolio')
            ->willThrowException(new \Exception());

        $controller = new PortfolioController();
        $controller->getPortfolio($this->portfolioService, $this->entityManager);
    }
}
