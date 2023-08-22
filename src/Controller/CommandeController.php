<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\DetailCommande;
use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CommandeController extends AbstractController
{
    #[Route('/commande/creation', name: 'app_commande')]
    public function commande(SessionInterface $session, ProduitRepository $produitRepository, EntityManagerInterface $manager, UserRepository $userRepository): Response
    {
        if (!$this->getUser()) 
        {
            return $this->redirectToRoute('login');
        }
        
        $form = $this->createForm(CommandeType::class, null, [
            'user' => $this->getUser()
        ]); 

        $user = $userRepository->find($this->getUser());

        $panier = $session->get('panier', []);

        if ($panier === []) {
            $this->addFlash('message', 'Votre panier es vide');
            return $this->redirectToRoute('app_accueil');
        }
        $liste = [];
        $total = 0;

        foreach ($panier as $article => $quantite) {
            $produit = $produitRepository->find($article);

            $liste[] =  [
                "produit" => $produit,
                "quantite" => $quantite,
                
            ];
            $total += $produit->getPrix() * $quantite;
        }

        // Le panier n'est pas vide on crée la commande
        $commande = new Commande();

        
        //On remplit la commande
        $commande->setUser($this->getUser());
        $commande->setDateCommande(new \DateTime());

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

        

        return $this->render('commande/commande.html.twig', [
            'form' => $form->createView(),
            'liste' => $liste,
            'total' => $total,
            'commande' => $commande,
        ]);

    }

    #[Route('/historique', name: 'app_historique')]
    public function historique(CommandeRepository $repository): Response
    {
        $commandes = $repository->findBy(['user' => $this->getUser()]);

        return $this->render('commande/historique.html.twig', [
            'commandes' => $commandes,
        ]);
        
        
    }

    
}










