<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Repository;

use App\Entity\TechnicalSkills;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechnicalSkills>
 *
 * @method TechnicalSkills|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnicalSkills|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnicalSkills[]    findAll()
 * @method TechnicalSkills[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TechnicalSkillsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnicalSkills::class);
    }
}
