<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories implements TranslatableInterface
{
    use TranslatableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
 * @var Collection<int, TechnicalSkills> 
*/
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: TechnicalSkills::class)]
    private Collection $technicalSkills;

    public function __construct()
    {
        $this->technicalSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $technicalSkill->setCategory($this);
        }

        return $this;
    }

    public function removeTechnicalSkill(TechnicalSkills $technicalSkill): static
    {
        if ($this->technicalSkills->removeElement($technicalSkill)) {
            // set the owning side to null (unless already changed)
            if ($technicalSkill->getCategory() === $this) {
                $technicalSkill->setCategory(null);
            }
        }

        return $this;
    }

    public function __get($name)
    {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $name);
    }

    public function getTitleTranslation()
    {
        return $this->translations->first()->getTitle();
    }

    public function __toString(): string
    {
        return $this->getTitleTranslation();
    }
}
