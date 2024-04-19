<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\ProjectsTranslation;
use PHPUnit\Framework\TestCase;

final class ProjectsTranslationTest extends TestCase
{
    public function testPropertiesAreNullable()
    {
        $project = new ProjectsTranslation();

        self::assertNull($project->getId());
        self::assertNull($project->getDescription());
    }

    public function testGetDescription(): void
    {
        $translation = new ProjectsTranslation();
        $translation->setDescription('Project description');

        self::assertEquals('Project description', $translation->getDescription());
    }

    public function testSetDescription(): void
    {
        $translation = new ProjectsTranslation();
        $translation->setDescription('Project description');

        self::assertEquals('Project description', $translation->getDescription());

        $translation->setDescription('New project description');
        self::assertEquals('New project description', $translation->getDescription());
    }
}
