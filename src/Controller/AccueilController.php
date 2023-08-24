<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
    public function produit(SousCategorie $souscategorie,  PaginatorInterface $paginator, Request $request): Response
    {
        $produits = $paginator->paginate(
            $souscategorie->getProduits(),
            $request->query->getInt('page', 1),
            6
        );
        
        return $this->render('accueil/souscategorie.html.twig', [
            'produits' => $produits,
            'souscategorie' => $souscategorie,
            
          
        ]);
       
    }

    #[Route('/detail/{id}', name: 'app_detail')]
    public function detail(Produit $produit): Response
    {
        return $this->render('accueil/detail.html.twig', [
            'detail' => $produit,
            
            
          
        ]);
       
    }

}
