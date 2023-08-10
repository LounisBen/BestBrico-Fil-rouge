<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Entity\SousCategorie;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProduitCrudController extends AbstractCrudController
{
    private $manager;
    
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    
    public function configureCrud(Crud $crud):Crud
    {
        return $crud
        ->setEntityLabelInPlural('Produits')
        ->setEntityLabelInSingular('Produit')
        ->setPageTitle('index', 'BestBrico - Administration des produits')
        ->setPageTitle('new', 'BestBrico - Ajout d\'un produit')
        ->setPageTitle('edit', function (Produit $produit) 
            {
                return 'Modification du produit : ' . $produit->getNom();
            })
        ->setPageTitle('detail', function (Produit $produit) 
            {
                return $produit->getNom();
            })
        ->setDefaultSort(['id' => 'ASC'])
        ->setPaginatorPageSize(15); 
    }

    

   
    public function configureFields(string $pageName): iterable
    {
        // On recupère toutes les SousCategories existantes (pour les choix de la SousCategorie quand on modifie/ajoute un Produit)
        $sousCategories = $this->manager->getRepository(SousCategorie::class)->findAll();

        if ($pageName=="new") 
        {
            return [
                TextField::new('nom'),
                TextareaField::new('description'),
                AssociationField::new('sousCategorie')
                    ->setFormTypeOptions([
                        'multiple' => false,
                        'class' => SousCategorie::class,
                        'choices' => $sousCategories,
                    ]),
                NumberField::new('prix'),
                IntegerField::new('stock'),
                TextField::new('imageFile')->setFormType(VichImageType::class),
            ];
        } 
        elseif ($pageName == "edit") 
        {
            return [
                TextField::new('nom'),
                TextareaField::new('description'),
                AssociationField::new('sousCategorie')
                    ->setFormTypeOptions([
                        'multiple' => false,
                        'class' => SousCategorie::class,
                        'choices' => $sousCategories,
                    ]),
                NumberField::new('prix'),
                IntegerField::new('stock'),
                TextField::new('imageFile')->setFormType(VichImageType::class),
            ];
        } 
        elseif ($pageName == "detail") 
        {
            return [
                IdField::new('id'),
                TextField::new('nom'),
                TextField::new('sousCategorie'),
                TextareaField::new('description'),
                NumberField::new('prix'),
                IntegerField::new('stock'),
                ImageField::new('imageName', 'Image')->setBasePath('/images/produit'),
                DateTimeField::new('createdAt'),
                DateTimeField::new('updatedAt'),
            ];
        } 
        else // page : index
        { 
            return [
                IdField::new('id'),
                TextField::new('nom'),
                TextField::new('sousCategorie'),
                NumberField::new('prix'),
                IntegerField::new('stock'),
                ImageField::new('imageName', 'Image')->setBasePath('/images/produit')
            ];
        }
    }
}
