<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();
        
        return $this->render('accueil/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/{id}', name: 'app_categorie')]
    public function categorie(Categorie $categorie): Response
    {
        $sousCategories = $categorie->getSousCategories();
        
        return $this->render('accueil/categorie.html.twig', [
            'categorie' => $categorie,
            'sousCategories' => $sousCategories,
          
        ]);
       
    }

    #[Route('/souscategorie/{id}', name: 'app_produit')]
    public function produit(SousCategorie $souscategorie): Response
    {
        $produits = $souscategorie->getProduits();
        
        return $this->render('accueil/souscategorie.html.twig', [
            'produits' => $produits,
            'souscategorie' => $souscategorie,
            
          
        ]);
       
    }

}
