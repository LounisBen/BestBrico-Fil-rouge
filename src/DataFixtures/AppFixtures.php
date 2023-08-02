<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }    
    
    public function load(ObjectManager $manager): void
    {

        // USERS
        $users = [];

        $admin = new User();
        $admin->setEmail('admin@bestbrico.com')
            ->setRoles(["ROLE_ADMIN"])
            ->setNom('administrateur') 
            ->setPrenom('admin')
            ->setAdresse('5 rue Vulfran Mollet')
            ->setCodePostal('80000') 
            ->setVille('Amiens')
            ->setPlainPassword('password');           
            
        $users[] = $admin;
        $manager->persist($admin);

        
    for ($j = 1; $j <=5; $j++)
        { 
        $user = new User();
        $user->setEmail($this->faker->email);
        $user ->setRoles(["ROLE_USER"]);
        $user->setNom($this->faker->name) ;
        $user->setPrenom($this->faker->firstName);
        $user->setAdresse($this->faker->streetAddress());
        $user->setCodePostal(str_replace(' ','', $this->faker->postcode)); 
        $user->setVille($this->faker->city);
        $user->setPlainPassword('password');
        
        $users[] = $user;
        $manager->persist($user);
        }

        // CATEGORIES
        $Categorie1 = new Categorie();
        $Categorie1->setNom("Gros oeuvre");
        $Categorie1->setImagesrc("/grosOeuvre.jpg");
        $manager->persist($Categorie1);
       
        $Categorie2 = new Categorie();
        $Categorie2->setNom("Menuiserie");
        $Categorie2->setImagesrc("/menuiserie.jpg");
        $manager->persist($Categorie2);
       
        $Categorie3 = new Categorie();
        $Categorie3->setNom("Electricité");
        $Categorie3->setImagesrc("/electricite.jpg");
        $manager->persist($Categorie3);

        $Categorie4 = new Categorie();
        $Categorie4->setNom("Plomberie et Sanitaire");
        $Categorie4->setImagesrc("/plomberieSanitaire.jpg");
        $manager->persist($Categorie4);

        $Categorie5 = new Categorie();
        $Categorie5->setNom("Outillage");
        $Categorie5->setImagesrc("/outillage.jpg");
        $manager->persist($Categorie5);

        $Categorie6 = new Categorie();
        $Categorie6->setNom("Peinture");
        $Categorie6->setImagesrc("/peinture.jpg");
        $manager->persist($Categorie6);

                // SOUS CATEGORIES
                $SousCategorie1 = new SousCategorie();
                $SousCategorie1->setNom("Construction");
                $SousCategorie1->setCategorie($Categorie1);
                $manager->persist($SousCategorie1);

                $SousCategorie2 = new SousCategorie();
                $SousCategorie2->setNom("Aménagement");
                $SousCategorie2->setCategorie($Categorie1);
                $manager->persist($SousCategorie2);
                
                $SousCategorie3 = new SousCategorie();
                $SousCategorie3->setNom("Menuiserie intérieure");
                $SousCategorie3->setCategorie($Categorie2);
                $manager->persist($SousCategorie3);

                $SousCategorie4 = new SousCategorie();
                $SousCategorie4->setNom("Menuiserie extérieure");
                $SousCategorie4->setCategorie($Categorie2);
                $manager->persist($SousCategorie4);

                $SousCategorie5 = new SousCategorie();
                $SousCategorie5->setNom("Cables,appareillages et luminaires");
                $SousCategorie5->setCategorie($Categorie3);
                $manager->persist($SousCategorie5);

                $SousCategorie6 = new SousCategorie();
                $SousCategorie6->setNom("Chauffage et Domotique");
                $SousCategorie6->setCategorie($Categorie3);
                $manager->persist($SousCategorie6);

                $SousCategorie7 = new SousCategorie();
                $SousCategorie7->setNom("Plomberie");
                $SousCategorie7->setCategorie($Categorie4);
                $manager->persist($SousCategorie7);

                $SousCategorie8 = new SousCategorie();
                $SousCategorie8->setNom("Sanitaire");
                $SousCategorie8->setCategorie($Categorie4);
                $manager->persist($SousCategorie8);

                $SousCategorie9 = new SousCategorie();
                $SousCategorie9->setNom("Machines et Outillage");
                $SousCategorie9->setCategorie($Categorie5);
                $manager->persist($SousCategorie9);

                $SousCategorie10 = new SousCategorie();
                $SousCategorie10->setNom("Consommables");
                $SousCategorie10->setCategorie($Categorie5);
                $manager->persist($SousCategorie10);

                $SousCategorie11 = new SousCategorie();
                $SousCategorie11->setNom("Peintures et poudres");
                $SousCategorie11->setCategorie($Categorie6);
                $manager->persist($SousCategorie11);

                $SousCategorie12 = new SousCategorie();
                $SousCategorie12->setNom("Droguerie");
                $SousCategorie12->setCategorie($Categorie6);
                $manager->persist($SousCategorie12);
         
                // PRODUITS
       for ($i=1 ; $i < 60 ; $i++ ) { 
            $produit = new Produit();
            $produit ->setNom($this->faker->word())
                ->setDescription($this->faker->text(200))
                ->setPrix(mt_rand(1, 5000))
                ->setStock(mt_rand(0, 1000))
                ->setActif(mt_rand(0, 1) == 1 ? true : false );
            $randomSousCategorie = $this->faker->randomElement([$SousCategorie1, $SousCategorie2, $SousCategorie3, $SousCategorie4, $SousCategorie5, $SousCategorie6, $SousCategorie7, $SousCategorie8, $SousCategorie9, $SousCategorie10, $SousCategorie11, $SousCategorie12]);
            $produit->setSousCategorie($randomSousCategorie);
            
            $manager->persist($produit);
       }

        $manager->flush();
    }
}
