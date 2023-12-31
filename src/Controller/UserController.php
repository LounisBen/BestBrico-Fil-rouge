<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods: ['GET', 'POST'])]
    public function userEdit(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->getUser())  // On vérifie si l'utilisateur est connecté
        {
        return $this->redirectToRoute('login');
        }

        if($this->getUser() !== $user )  // On vérifie que l'utilisateur connecté n'a accès qu'à son propre profil
        {
        return $this->redirectToRoute('app_accueil');
        }

        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())
            ) {
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Les informations de votre compte ont bien été modifiées.'
                );

                return $this->redirectToRoute('app_accueil');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe est invalide.'
                );
            }
        }
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/utilisateur/edition-mot-de-passe/{id}', name: 'editPassword', methods: ['GET', 'POST'])] 
    public function editPassword(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->getUser())  
        {
        return $this->redirectToRoute('login');
        }

        if($this->getUser() !== $user )  
        {
        return $this->redirectToRoute('app_accueil');
        }
        
        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                if ($hasher->isPasswordValid($user, $form->getData()['plainPassword'])) { 
                    $user->setUpdatedAt(new \DateTimeImmutable());
                    $user->setPlainPassword(
                        $form->getData()['newPassword']
                    );

                    $manager->persist($user);
                    $manager->flush();

                    $this->addFlash(
                        'success',
                        'Le mot de passe a bien été modifié.'
                    );

                    return $this->redirectToRoute('app_accueil');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe est invalide.'
                );
            }   
                 
        }
    
            return $this->render('user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);

    }

}





   

    
       
