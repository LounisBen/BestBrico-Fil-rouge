<?php

namespace App\Controller\Admin;

use App\Entity\Livraison;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class LivraisonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livraison::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Livraisons')
        ->setEntityLabelInSingular('Livraison')
        ->setPageTitle('index', 'BestBrico - Gestion de la livraison')
        ->setPageTitle('new', 'BestBrico - Ajout d\'un mode de livraison')
        ->setPageTitle('edit', function (Livraison $livraison) 
            {
                return 'Modification de la livraison : ' . $livraison->getTitre();
            })
        ->setPageTitle('detail', function (Livraison $livraison) 
            {
                return $livraison->getTitre();
            })
        ->setDefaultSort(['id' => 'ASC'])
        ->setPaginatorPageSize(5); 
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('titre'),
            TextareaField::new('descriptif'),
            MoneyField::new('prix')->setCurrency('EUR'),
        ];
    }
    
}
