<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Repository;

use App\Entity\InterpersonalSkills;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InterpersonalSkills>
 *
 * @method InterpersonalSkills|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterpersonalSkills|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterpersonalSkills[]    findAll()
 * @method InterpersonalSkills[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterpersonalSkillsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterpersonalSkills::class);
    }
}
