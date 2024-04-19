<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Repository;

use App\Entity\ProjectsTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectsTranslation>
 *
 * @method ProjectsTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectsTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectsTranslation[]    findAll()
 * @method ProjectsTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectsTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectsTranslation::class);
    }
}
