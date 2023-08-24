<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class NavController extends AbstractController
{
    public function index(CategorieRepository $repo, SessionInterface $session): Response
    {
        return $this->render('partials/_navbar.html.twig', [
            'categories' => $repo->findAll(),
            'panier' => $session->get('panier', [])
        ]);
    }
}
