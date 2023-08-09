<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs')
            ->setEntityLabelInSingular('Utilisateur')
            ->setPageTitle('index', 'BestBrico - Administration des utilisateurs')
            // ->setPageTitle('new', 'Ajout d\'un utilisateur')
            // ->setPageTitle('edit', function (User $user) 
            //     {
            //         return 'Modification de l\'utilisateur : ' . $user->getNom();
            //     })
            // ->setPageTitle('detail', function (User $user) 
            //     {
            //         return $user->getNom();
            //     })
            // ->setDefaultSort(['id' => 'ASC'])
            ->setPaginatorPageSize(15); // Nombre d'utilisateurs par page
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email')
                ->hideOnForm()
                ->setFormTypeOption('disabled', 'disabled'),
            ArrayField::new('roles'),
            DateTimeField::new('createdAt')
                ->hideOnForm()
                ->setFormTypeOption('disabled', 'disabled'),
            
            
        ];
    }
    
}
