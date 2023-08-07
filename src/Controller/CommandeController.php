<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function commande(SessionInterface $session, ProduitRepository $produitRepository, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");

        $panier = $session->get('panier', []);
        if ($panier === []) {
            $this->addFlash('message', 'Votre panier es vide');
            return $this->redirectToRoute('app_accueil');
        }
        // Le panier n'est pas vide on crée la commande
        $commande = new Commande();

        //On remplit la commande
        $commande->setUser($this->getUser());
        $commande->setReference(uniqid());

        // On parcourt les détails de commande pour créer la commande
        foreach ($panier  as $article => $quantite) {
            $detailCommande = new DetailCommande();
        
            $produit = $produitRepository->find($article);
            // dd($produit);
            $prix = $produit->getPrix();

        // On crée le détail de commandes
        $detailCommande->setProduit($produit);
        $detailCommande->setPrix($prix);
;       $detailCommande->setQuantite($quantite);

            $commande->addDetailCommande($detailCommande);

        }

        //On persiste et on flush

        $manager->persist($commande);
        $manager->flush();

        $session->remove('panier');
        
        $this->addFlash(
            'success',
            'Votre commande a été créée avec succès');

        return $this->redirectToRoute('app_accueil');
    }

    
}
