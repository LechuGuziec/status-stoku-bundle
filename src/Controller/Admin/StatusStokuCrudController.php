<?php

namespace LechuGuziec\StatusStokuBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use LechuGuziec\StatusStokuBundle\Entity\StatusStoku;
use LechuGuziec\StatusStokuBundle\Enum\WarunkiStatus;
use LechuGuziec\StatusStokuBundle\Enum\WyciagiStatus;

final class StatusStokuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StatusStoku::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('wyciagi', 'Wyciągi')
            ->setChoices(WyciagiStatus::choices())
            ->allowMultipleChoices(false)
            ->renderExpanded(false);

        yield IntegerField::new('pokrywa', 'Pokrywa (cm)')
            ->setHelp('Wpisz liczbę w cm (0–600).')
            ->setFormTypeOption('attr', ['min' => 0, 'max' => 600, 'step' => 1]);

        yield ChoiceField::new('warunki', 'Warunki')
            ->setChoices(WarunkiStatus::choices())
            ->allowMultipleChoices(false);

        yield DateTimeField::new('createdAt', 'Data utworzenia')->onlyOnIndex();
        yield DateTimeField::new('updatedAt', 'Data edycji')->onlyOnIndex();
    }
}
