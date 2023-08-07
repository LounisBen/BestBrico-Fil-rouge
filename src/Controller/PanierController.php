<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function panier(ProduitRepository $produitRepository, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        //On initialise les variables
        $liste = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $produit = $produitRepository->find($id);

            $liste[] = [
                'produit' => $produit,
                'quantite' => $quantite
            ];
            $total += $produit->getPrix() * $quantite;

        }
        return $this->render('panier/panier.html.twig', [
            'liste' => $liste,
            'total' => $total,
        ]);
    }
    
    
    #[Route('/add/{id}', name: 'app_add')]
    public function add(Produit $produit, SessionInterface $session): Response
    {
        //On récupère l'id du produit
        $id = $produit->getId();

        //On récupère le panier existant
        $panier = $session->get('panier', []);

        //On ajoute le produit dans le panier s'il n'y est pas encore
        //sinon on incrémente sa quantité
        if (empty($panier[$id])) {
            $panier[$id] = 1;
        } else {
            $panier[$id]++;
        }

        $session->set('panier', $panier);
          
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/remove/{id}', name: 'app_remove')]
    public function remove(Produit $produit, SessionInterface $session): Response
    {
        //On récupère l'id du produit
        $id = $produit->getId();

        //On récupère le panier existant
        $panier = $session->get('panier', []);

        //On retire le produit dans le panier s'il n'y a qu'1 produit
        //sinon on décrémente 
        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);
          
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(Produit $produit, SessionInterface $session): Response
    {
        //On récupère l'id du produit
        $id = $produit->getId();

        //On récupère le panier existant
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);
          
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/empty', name: '_empty')]
    public function empty(SessionInterface $session): Response
    {
        // On vide le panier de la session
        $session->remove('panier');

        return $this->redirectToroute("app_panier");
    }
}
