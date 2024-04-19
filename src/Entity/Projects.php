<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

#[ORM\Entity(repositoryClass: ProjectsRepository::class)]
final class Projects implements TranslatableInterface
{
    use TranslatableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlDemo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlGit = null;

    /** @var Collection<int, TechnicalSkills> */
    #[ORM\ManyToMany(targetEntity: TechnicalSkills::class, inversedBy: 'projects')]
    private Collection $technicalSkills;

    public function __construct()
    {
        $this->technicalSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getUrlDemo(): ?string
    {
        return $this->urlDemo;
    }

    public function setUrlDemo(?string $urlDemo): static
    {
        $this->urlDemo = $urlDemo;

        return $this;
    }

    public function getUrlGit(): ?string
    {
        return $this->urlGit;
    }

    public function setUrlGit(?string $urlGit): static
    {
        $this->urlGit = $urlGit;

        return $this;
    }

    /**
     * @return Collection<int, TechnicalSkills>
     */
    public function getTechnicalSkills(): Collection
    {
        return $this->technicalSkills;
    }

    public function addTechnicalSkill(TechnicalSkills $technicalSkill): static
    {
        if (!$this->technicalSkills->contains($technicalSkill)) {
            $this->technicalSkills->add($technicalSkill);
        }

        return $this;
    }

    public function removeTechnicalSkill(TechnicalSkills $technicalSkill): static
    {
        $this->technicalSkills->removeElement($technicalSkill);

        return $this;
    }
}
