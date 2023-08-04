<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }
    /**
     * This controller allows us to logout
     *
     * @return void
     */
    #[Route('/deconnexion', name: 'logout')]
    public function logout()
    {
        //Nothing to do here..
    }
    /**
     * This controller allows us to register
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/inscription', name: 'registration', methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $user = $form->getData();

            $this->addFlash(
                'success',
                'Bienvenue "'. $user->getPrenom() .'" , votre compte a bien été créé !'
            );

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('login');
        }
        
        
        return $this->render('security/registration.html.twig', [
            'form' =>$form->createView()
        ]);
    }
}
