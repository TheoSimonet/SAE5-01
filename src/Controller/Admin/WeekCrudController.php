<?php

namespace App\Controller\Admin;

use App\Entity\Week;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class WeekCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Week::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Semaines')
            ->setEntityLabelInSingular('Semaine');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            IntegerField::new('weekNumber'),
            IntegerField::new('numberHours'),
            CollectionField::new('Subject')
                ->hideOnIndex(),
        ];
    }
}
