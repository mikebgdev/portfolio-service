<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Repository;

use App\Entity\WorkExperience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkExperience>
 *
 * @method WorkExperience|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkExperience|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkExperience[]    findAll()
 * @method WorkExperience[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class WorkExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkExperience::class);
    }
}
