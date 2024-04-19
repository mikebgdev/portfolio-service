<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\AboutMe;
use App\Entity\AboutMeTranslation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AboutMeService
{
    private EntityManagerInterface $manager;
    private ParameterBagInterface $params;

    public function __construct(EntityManagerInterface $manager, ParameterBagInterface $params)
    {
        $this->manager = $manager;
        $this->params = $params;
    }

    /**
     * @throws \Exception
     */
    public function buildAboutMe(): ?array
    {
        $aboutMe = $this->manager->getRepository(AboutMe::class)->findOneBy([], ['id' => 'ASC']);

        if (empty($aboutMe)) {
            return null;
        }

        $translations = $this->mapTranslations($aboutMe->getTranslations());

        $photo = null === $aboutMe->getPhotoPath() ?
            null :
            $this->params->get('upload_photo_directory').'/'.$aboutMe->getPhotoPath();
        $curriculum = null === $aboutMe->getCurriculumPath() ?
            null :
            $this->params->get('upload_curriculum_directory').'/'.$aboutMe->getCurriculumPath();

        return [
            'name' => $aboutMe->getName(),
            'age' => $aboutMe->getAge(),
            'email' => $aboutMe->getEmail(),
            'location' => $aboutMe->getLocation(),
            'photo' => $photo,
            'curriculum' => $curriculum,
            'translations' => $translations,
        ];
    }

    public function mapTranslations($translations): array
    {
        $translationsArr = [];

        /**
         * @var AboutMeTranslation $translation
         */
        foreach ($translations as $key => $translation) {
            $translationsArr[$key] = [
                'nationality' => $translation->getNationality(),
                'paragraph1' => $translation->getParagraph1(),
                'paragraph2' => $translation->getParagraph2(),
            ];
        }

        return $translationsArr;
    }
}
