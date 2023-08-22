<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Livraison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('adresses', EntityType::class, [
                'class' => Adresse::class,
                'attr' => [
                    'class' => 'form-control',
                ],
                'expanded' => true,
                'label' => 'Sélectionner votre adresse de livraison:',
                'required' => true,
                'multiple' => false,
                
                'choices' => $user->getAdresses(),
                
                
            ])

            ->add('livraison', EntityType::class, [
                'class' => Livraison::class,
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Choisissez votre mode de livraison:',
                'required' => true,
                'multiple' => false,
                'expanded' => true,

            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-secondary mt-4'
                ],
                'label' => 'Valider votre commande'
            
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => []
        ]);
    }
}
