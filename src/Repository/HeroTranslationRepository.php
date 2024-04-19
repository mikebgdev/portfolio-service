<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Repository;

use App\Entity\HeroTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HeroTranslation>
 *
 * @method HeroTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method HeroTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method HeroTranslation[]    findAll()
 * @method HeroTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class HeroTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HeroTranslation::class);
    }
}
