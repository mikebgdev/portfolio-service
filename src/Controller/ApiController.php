<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Education;
use App\Entity\TechnicalSkills;
use App\Entity\WorkExperience;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    public function getContent(EntityManagerInterface $entityManager): JsonResponse
    {
        $education = $entityManager->getRepository(Education::class)->findAll();
        $workExperience = $entityManager->getRepository(WorkExperience::class)->findAll();
        $technicalSkills = $entityManager->getRepository(TechnicalSkills::class)->findAll();

        $response = [
            'education' => $education,
            'workExperience' => $workExperience,
            'technicalSkills' => $technicalSkills,
        ];

        return $this->json($response);
    }
}
