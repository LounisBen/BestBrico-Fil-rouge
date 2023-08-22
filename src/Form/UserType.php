<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
        ->add('nom', TextType::class, [
            'attr' => [
                 'class' =>'form-control'
            ],
            'label' => 'Nom :' 
        ])

         ->add('prenom', Texttype::class, [
            'attr' => [
                 'class' =>'form-control'
            ],
            'label' => 'Prénom :' 
        ])
        //   ->add('adresse', TextType::class, [
        //      'attr' => [
        //          'class' => 'form-control'
        //      ],
        //      'label' => 'Adresse :'
        // ])
        //  ->add('codePostal', TextType::class, [
        //      'attr' => [
        //          'class' => 'form-control'
        //      ],
        //      'label' => 'Code Postal :'
        // ])
        //  ->add('ville', TextType::class, [
        //      'attr' => [
        //          'class' => 'form-control'
        //      ],
        //      'label' => 'Ville :'
        // ])

        ->add('plainPassword', PasswordType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Veuillez entrer votre mot de passe afin de valider les modifications de votre profil',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]
        ])

         ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4'
            ],
            'label' => 'Valider les modifications'
        ]);    
            
    } 
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
        
}
