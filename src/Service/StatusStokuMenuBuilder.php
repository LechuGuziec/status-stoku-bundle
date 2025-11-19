<?php

namespace LechuGuziec\StatusStokuBundle\Service;

use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Menu\MenuItemInterface;
use LechuGuziec\StatusStokuBundle\Controller\Admin\StatusStokuCrudController;
use LechuGuziec\StatusStokuBundle\Entity\StatusStoku;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class StatusStokuMenuBuilder
{
    public function __construct(
        #[Autowire(param: 'status_stoku.easyadmin_menu_label')] private string $label,
        #[Autowire(param: 'status_stoku.easyadmin_menu_icon')] private string $icon
    ) {}

    public function build(): MenuItemInterface
    {
        return MenuItem::linkToCrud($this->label, $this->icon, StatusStoku::class)
            ->setController(StatusStokuCrudController::class);
    }
}
