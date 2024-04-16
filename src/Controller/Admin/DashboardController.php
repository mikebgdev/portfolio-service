<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\AboutMe;
use App\Entity\Education;
use App\Entity\WorkExperience;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Api Portfolio Symfony')
            ->setFaviconPath('icon-dev-logo.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Configuration');
        yield MenuItem::linkToCrud('AboutMe', 'fas fa-user', AboutMe::class);
        yield MenuItem::linkToCrud('Technical Skills', 'fas fa-code', AboutMe::class);
        yield MenuItem::linkToCrud('Interpersonal Skills', 'fas fa-handshake', AboutMe::class);
        yield MenuItem::linkToCrud('Projects', 'fas fa-table', AboutMe::class);
        yield MenuItem::linkToCrud('Work Experience', 'fas fa-briefcase', WorkExperience::class);
        yield MenuItem::linkToCrud('Education', 'fas fa-school', Education::class);
        yield MenuItem::section('Links');
        yield MenuItem::linkToUrl('Web', 'fas fa-link', 'https://www.mikebgdev.com');
    }
}
