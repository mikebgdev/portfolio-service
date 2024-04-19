<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\SocialNetworks;
use Doctrine\ORM\EntityManagerInterface;

final class SocialNetworksService
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function buildSocialNetworks(): ?array
    {
        $socialNetworks = $this->manager->getRepository(SocialNetworks::class)->findAll();

        if (empty($socialNetworks)) {
            return null;
        }

        $socialNetworksArr = [];

        /**
         * @var SocialNetworks $socialNetwork
         */
        foreach ($socialNetworks as $socialNetwork) {
            $socialNetworksArr[] = $this->mapSocialNetworks($socialNetwork);
        }

        return $socialNetworksArr;
    }

    public function mapSocialNetworks(SocialNetworks $socialNetwork): array
    {
        return [
            'title' => $socialNetwork->getTitle(),
            'url' => $socialNetwork->getUrl(),
            'svg' => $socialNetwork->getSvg(),
        ];
    }
}
