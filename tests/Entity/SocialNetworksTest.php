<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\SocialNetworks;
use PHPUnit\Framework\TestCase;

#[covers(SocialNetworks::class)]
final class SocialNetworksTest extends TestCase
{
    public function testPropertiesAreNullable()
    {
        $socialNetwork = new SocialNetworks();

        self::assertNull($socialNetwork->getId());
        self::assertNull($socialNetwork->getTitle());
        self::assertNull($socialNetwork->getUrl());
        self::assertNull($socialNetwork->getSvg());
    }

    public function testGetSetTitle()
    {
        $socialNetwork = new SocialNetworks();

        $socialNetwork->setTitle('Facebook');

        self::assertEquals('Facebook', $socialNetwork->getTitle());
    }

    public function testGetSetUrl()
    {
        $socialNetwork = new SocialNetworks();

        $socialNetwork->setUrl('https://www.facebook.com');

        self::assertEquals('https://www.facebook.com', $socialNetwork->getUrl());
    }

    public function testGetSetSvg()
    {
        $socialNetwork = new SocialNetworks();

        $socialNetwork->setSvg('<svg>...</svg>');

        self::assertEquals('<svg>...</svg>', $socialNetwork->getSvg());
    }
}
