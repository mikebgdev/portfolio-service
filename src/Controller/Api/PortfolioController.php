<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\PortfolioService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PortfolioController extends AbstractController
{
    public function getPortfolio(PortfolioService $portfolioService, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $data = $portfolioService->buildPortfolio();
        } catch (\Exception $e) {
            throw new NotFoundHttpException('Portfolio not found');
        }

        return new JsonResponse($data);
    }
}
