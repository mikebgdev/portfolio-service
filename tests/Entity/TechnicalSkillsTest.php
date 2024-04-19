<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Tests\Entity;

use App\Entity\Categories;
use App\Entity\Projects;
use App\Entity\TechnicalSkills;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

#[covers(TechnicalSkills::class)]
final class TechnicalSkillsTest extends TestCase
{
    public function testPropertiesAreNullable()
    {
        $technicalSkill = new TechnicalSkills();

        self::assertNull($technicalSkill->getId());
        self::assertNull($technicalSkill->getTitle());
        self::assertNull($technicalSkill->getSvg());
    }

    public function testGetSetTitle()
    {
        $technicalSkill = new TechnicalSkills();

        $technicalSkill->setTitle('PHP');

        self::assertEquals('PHP', $technicalSkill->getTitle());
    }

    public function testGetSetSvg()
    {
        $technicalSkill = new TechnicalSkills();

        $technicalSkill->setSvg('<svg>...</svg>');

        self::assertEquals('<svg>...</svg>', $technicalSkill->getSvg());
    }

    public function testGetSetCategory()
    {
        $technicalSkill = new TechnicalSkills();
        $category = new Categories();

        $technicalSkill->setCategory($category);

        self::assertEquals($category, $technicalSkill->getCategory());
    }

    public function testGetProjectsReturnsCollection(): void
    {
        $technicalSkill = new TechnicalSkills();
        $projects = $technicalSkill->getProjects();

        self::assertInstanceOf(Collection::class, $projects);
        self::assertCount(0, $projects);
    }

    public function testAddProject(): void
    {
        $technicalSkill = new TechnicalSkills();
        $project = new Projects();

        $technicalSkill->addProject($project);
        $projects = $technicalSkill->getProjects();

        self::assertCount(1, $projects);
        self::assertTrue($projects->contains($project));
    }

    public function testAddProjectTwice(): void
    {
        $technicalSkill = new TechnicalSkills();
        $project = new Projects();

        $technicalSkill->addProject($project);
        $technicalSkill->addProject($project);

        $projects = $technicalSkill->getProjects();

        self::assertCount(1, $projects);
    }

    public function testRemoveProject(): void
    {
        $technicalSkill = new TechnicalSkills();
        $project = new Projects();

        $technicalSkill->addProject($project);
        $technicalSkill->removeProject($project);

        $projects = $technicalSkill->getProjects();

        self::assertCount(0, $projects);
        self::assertFalse($projects->contains($project));
    }

    public function testRemoveNonExistingProject(): void
    {
        $technicalSkill = new TechnicalSkills();
        $project = new Projects();

        $technicalSkill->removeProject($project);

        $projects = $technicalSkill->getProjects();

        self::assertCount(0, $projects);
    }

    public function testToString()
    {
        $technicalSkill = new TechnicalSkills();
        $technicalSkill->setTitle('Skill');

        self::assertEquals('Skill', $technicalSkill->__toString());
    }
}
