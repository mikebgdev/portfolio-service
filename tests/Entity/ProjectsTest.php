<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Projects;
use App\Entity\TechnicalSkills;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

final class ProjectsTest extends TestCase
{
    public function testPropertiesAreNullable()
    {
        $project = new Projects();

        self::assertNull($project->getId());
        self::assertNull($project->getTitle());
        self::assertNull($project->getUrlDemo());
        self::assertNull($project->getUrlGit());
    }

    public function testGetTitle(): void
    {
        $project = new Projects();
        $project->setTitle('Project title');

        self::assertEquals('Project title', $project->getTitle());
    }

    public function testSetTitle(): void
    {
        $project = new Projects();
        $project->setTitle('Project title');

        self::assertEquals('Project title', $project->getTitle());

        $project->setTitle('New project title');
        self::assertEquals('New project title', $project->getTitle());
    }

    public function testGetUrlDemo(): void
    {
        $project = new Projects();
        $project->setUrlDemo('https://example.com/demo');

        self::assertEquals('https://example.com/demo', $project->getUrlDemo());
    }

    public function testSetUrlDemo(): void
    {
        $project = new Projects();
        $project->setUrlDemo('https://example.com/demo');

        self::assertEquals('https://example.com/demo', $project->getUrlDemo());

        $project->setUrlDemo('https://example.com/new-demo');
        self::assertEquals('https://example.com/new-demo', $project->getUrlDemo());
    }

    public function testGetUrlGit(): void
    {
        $project = new Projects();
        $project->setUrlGit('https://github.com/example');

        self::assertEquals('https://github.com/example', $project->getUrlGit());
    }

    public function testSetUrlGit(): void
    {
        $project = new Projects();
        $project->setUrlGit('https://github.com/example');

        self::assertEquals('https://github.com/example', $project->getUrlGit());

        $project->setUrlGit('https://github.com/new-example');
        self::assertEquals('https://github.com/new-example', $project->getUrlGit());
    }

    public function testGetSkillsReturnsCollection(): void
    {
        $project = new Projects();
        $skills = $project->getTechnicalSkills();

        self::assertInstanceOf(Collection::class, $skills);
        self::assertCount(0, $skills);
    }

    public function testAddSkill(): void
    {
        $project = new Projects();
        $skill = new TechnicalSkills();

        $project->addTechnicalSkill($skill);
        $skills = $project->getTechnicalSkills();

        self::assertCount(1, $skills);
        self::assertTrue($skills->contains($skill));
    }

    public function testAddSkillTwice(): void
    {
        $project = new Projects();
        $skill = new TechnicalSkills();

        $project->addTechnicalSkill($skill);
        $project->addTechnicalSkill($skill);

        $skills = $project->getTechnicalSkills();

        self::assertCount(1, $skills);
    }

    public function testRemoveSkill(): void
    {
        $project = new Projects();
        $skill = new TechnicalSkills();

        $project->addTechnicalSkill($skill);
        $project->removeTechnicalSkill($skill);

        $skills = $project->getTechnicalSkills();

        self::assertCount(0, $skills);
        self::assertFalse($skills->contains($skill));
    }

    public function testRemoveNonExistingSkill(): void
    {
        $project = new Projects();
        $skill = new TechnicalSkills();

        $project->removeTechnicalSkill($skill);

        $skills = $project->getTechnicalSkills();

        self::assertCount(0, $skills);
    }
}
