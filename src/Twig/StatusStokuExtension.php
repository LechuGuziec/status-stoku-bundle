<?php

namespace LechuGuziec\StatusStokuBundle\Service;

use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use LechuGuziec\StatusStokuBundle\Controller\Admin\StatusStokuCrudController;
use LechuGuziec\StatusStokuBundle\Entity\StatusStoku;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class StatusStokuExtension
{
    public function __construct(
        #[Autowire(param: 'status_stoku.easyadmin_menu_label')] private string $label,
        #[Autowire(param: 'status_stoku.easyadmin_menu_icon')] private string $icon
    ) {}

    public function buildMenuItem(): MenuItem
    {
        return MenuItem::linkToCrud($this->label, $this->icon, StatusStoku::class)
            ->setController(StatusStokuCrudController::class);
    }
}
