<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AboutMeTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

#[ORM\Entity(repositoryClass: AboutMeTranslationRepository::class)]
class AboutMeTranslation implements TranslationInterface
{
    use TranslationTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nationality = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $paragraph1 = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $paragraph2 = null;

    public function getParagraph1(): ?string
    {
        return $this->paragraph1;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function setParagraph1(?string $paragraph1): static
    {
        $this->paragraph1 = $paragraph1;

        return $this;
    }

    public function getParagraph2(): ?string
    {
        return $this->paragraph2;
    }

    public function setParagraph2(?string $paragraph2): static
    {
        $this->paragraph2 = $paragraph2;

        return $this;
    }
}
