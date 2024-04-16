<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Repository;

use App\Entity\WorkExperienceTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkExperienceTranslation>
 *
 * @method WorkExperienceTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkExperienceTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkExperienceTranslation[]    findAll()
 * @method WorkExperienceTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkExperienceTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkExperienceTranslation::class);
    }
}
