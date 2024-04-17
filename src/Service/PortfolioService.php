<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Service;

class PortfolioService
{
    private AboutMeService $aboutMeService;
    private TechnicalSkillsService $technicalSkillsService;
    private InterpersonalSkillsService $interpersonalSkillsService;
    private ProjectsService $projectsService;
    private WorkExperienceService $workExperienceService;
    private EducationService $educationService;
    private SocialNetworksService $socialNetworksService;

    public function __construct(
        AboutMeService $aboutMeService,
        TechnicalSkillsService $technicalSkillsService,
        InterpersonalSkillsService $interpersonalSkillsService,
        ProjectsService $projectsService,
        WorkExperienceService $workExperienceService,
        EducationService $educationService,
        SocialNetworksService $socialNetworksService
    ) {
        $this->aboutMeService = $aboutMeService;
        $this->technicalSkillsService = $technicalSkillsService;
        $this->interpersonalSkillsService = $interpersonalSkillsService;
        $this->projectsService = $projectsService;
        $this->workExperienceService = $workExperienceService;
        $this->educationService = $educationService;
        $this->socialNetworksService = $socialNetworksService;
    }

    /**
     * @throws \Exception
     */
    public function buildPortfolio(): array
    {
        return [
            'aboutMe' => $this->aboutMeService->buildAboutMe(),
            'technicalSkills' => $this->technicalSkillsService->buildTechnicalSkills(),
            'interpersonalSkills' => $this->interpersonalSkillsService->buildInterpersonalSkills(),
            'projects' => $this->projectsService->buildProjects(),
            'workExperience' => $this->workExperienceService->buildWorkExperience(),
            'education' => $this->educationService->buildEducation(),
            'socialNetworks' => $this->socialNetworksService->buildSocialNetworks(),
        ];
    }
}
