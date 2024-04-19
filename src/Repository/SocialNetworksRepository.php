<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Repository;

use App\Entity\SocialNetworks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SocialNetworks>
 *
 * @method SocialNetworks|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocialNetworks|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocialNetworks[]    findAll()
 * @method SocialNetworks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class SocialNetworksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocialNetworks::class);
    }
}
