<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Adresse;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Livraison;
use App\Entity\SousCategorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
                    ->setRoles(["ROLE_USER", "ROLE_ADMIN"])
                    ->setNom('administrateur') 
                    ->setPrenom('admin')
                    ->setPlainPassword('admin');           
                    
                $users[] = $admin;
                $manager->persist($admin);

                
            for ($j = 1; $j <=5; $j++)
                { 
                $user = new User();
                $user->setEmail($this->faker->email);
                $user ->setRoles(["ROLE_USER"]);
                $user->setNom($this->faker->name) ;
                $user->setPrenom($this->faker->firstName);
                $user->setPlainPassword('passwd');
                
                $users[] = $user;
                $manager->persist($user);
                }

                // CATEGORIES
                $Categorie1 = new Categorie();
                $Categorie1->setNom("GROS OEUVRE");
                $Categorie1->setImagesrc("/grosOeuvre.jpg");
                $manager->persist($Categorie1);
            
                $Categorie2 = new Categorie();
                $Categorie2->setNom("MENUISERIE");
                $Categorie2->setImagesrc("/menuiserie.jpg");
                $manager->persist($Categorie2);
            
                $Categorie3 = new Categorie();
                $Categorie3->setNom("ELECTRICITE");
                $Categorie3->setImagesrc("/electricite.jpg");
                $manager->persist($Categorie3);

                $Categorie4 = new Categorie();
                $Categorie4->setNom("PLOMBERIE/SANITAIRE");
                $Categorie4->setImagesrc("/plomberieSanitaire.jpg");
                $manager->persist($Categorie4);

                $Categorie5 = new Categorie();
                $Categorie5->setNom("OUTILLAGE");
                $Categorie5->setImagesrc("/outillage.jpg");
                $manager->persist($Categorie5);

                $Categorie6 = new Categorie();
                $Categorie6->setNom("PEINTURE");
                $Categorie6->setImagesrc("/peinture.jpg");
                $manager->persist($Categorie6);

                // SOUS CATEGORIES
                $SousCategorie1 = new SousCategorie();
                $SousCategorie1->setNom("Construction");
                $SousCategorie1->setDescriptif("Tous vos matériaux, du parpaing à la charpente pour vos travaux de rénovation ou de construction");
                $SousCategorie1->setImagesrc("/construction.jpg");
                $SousCategorie1->setCategorie($Categorie1);
                $manager->persist($SousCategorie1);

                $SousCategorie2 = new SousCategorie();
                $SousCategorie2->setNom("Aménagement");
                $SousCategorie2->setDescriptif("Tous vos produits pour aménager votre intérieur, cloison, isolation");
                $SousCategorie2->setImagesrc("/amenagement.jpg");
                $SousCategorie2->setCategorie($Categorie1);
                $manager->persist($SousCategorie2);
                
                $SousCategorie3 = new SousCategorie();
                $SousCategorie3->setNom("Intérieure");
                $SousCategorie3->setDescriptif("Tous vos produits bois pour l'intérieur, u tasseau au bloc-porte, revêtements sol, rangement");
                $SousCategorie3->setImagesrc("/menuiserieInterieure.jpg");
                $SousCategorie3->setCategorie($Categorie2);
                $manager->persist($SousCategorie3);

                $SousCategorie4 = new SousCategorie();
                $SousCategorie4->setNom("Extérieure");
                $SousCategorie4->setDescriptif("Toutes vos menuiseries pour l'extérieur, fenêtres, portes de garage, portes d'entrée");
                $SousCategorie4->setImagesrc("/menuiserieExterieure.jpg");
                $SousCategorie4->setCategorie($Categorie2);
                $manager->persist($SousCategorie4);

                $SousCategorie5 = new SousCategorie();
                $SousCategorie5->setNom("Cables.Appareillages");
                $SousCategorie5->setDescriptif("Cables en bobines, à la découpe, appareillages et accessoires");
                $SousCategorie5->setImagesrc("/cablesAppareillages.jpg");
                $SousCategorie5->setCategorie($Categorie3);
                $manager->persist($SousCategorie5);

                $SousCategorie6 = new SousCategorie();
                $SousCategorie6->setNom("Chauffage.Domotique");
                $SousCategorie6->setDescriptif("Notre gamme chauffauge, du radiateur rayonnant au radiateur fonte, ou à inertie séche, gamme VMC, ainsi qu'une gamme complète pour piloter votre foyer");
                $SousCategorie6->setImagesrc("/chauffageDomotique.jpg");
                $SousCategorie6->setCategorie($Categorie3);
                $manager->persist($SousCategorie6);

                $SousCategorie7 = new SousCategorie();
                $SousCategorie7->setNom("Plomberie");
                $SousCategorie7->setDescriptif("Cuivre, PER, multicouche, choudières, adoucisseurs,  tout le matériel pour le traitement de l'eau ");
                $SousCategorie7->setImagesrc("/plomberie.jpg");
                $SousCategorie7->setCategorie($Categorie4);
                $manager->persist($SousCategorie7);

                $SousCategorie8 = new SousCategorie();
                $SousCategorie8->setNom("Sanitaire");
                $SousCategorie8->setDescriptif("Cabines, receveurs, parois, tout l'équipement pour les salles d'eau");
                $SousCategorie8->setImagesrc("/sanitaire.jpg");
                $SousCategorie8->setCategorie($Categorie4);
                $manager->persist($SousCategorie8);

                $SousCategorie9 = new SousCategorie();
                $SousCategorie9->setNom("Equipement");
                $SousCategorie9->setDescriptif("Machines outils, outillage à main, équipements de protection individuelle");
                $SousCategorie9->setImagesrc("/machinesOutils.jpg");
                $SousCategorie9->setCategorie($Categorie5);
                $manager->persist($SousCategorie9);

                $SousCategorie10 = new SousCategorie();
                $SousCategorie10->setNom("Consommables");
                $SousCategorie10->setDescriptif("Abrasifs, accessoires machines, visserie et protection");
                $SousCategorie10->setImagesrc("/consommables.jpg");
                $SousCategorie10->setCategorie($Categorie5);
                $manager->persist($SousCategorie10);

                $SousCategorie11 = new SousCategorie();
                $SousCategorie11->setNom("Peintures/Poudres");
                $SousCategorie11->setDescriptif("Peintures intérieures et extérieures, à la teinte, enduits, platres");
                $SousCategorie11->setImagesrc("/peinturePoudres.jpg");
                $SousCategorie11->setCategorie($Categorie6);
                $manager->persist($SousCategorie11);

                $SousCategorie12 = new SousCategorie();
                $SousCategorie12->setNom("Droguerie");
                $SousCategorie12->setDescriptif("Tous le produits d'entretien et de nettoyage pour vos chantiers");
                $SousCategorie12->setImagesrc("/droguerie.jpg");
                $SousCategorie12->setCategorie($Categorie6);
                $manager->persist($SousCategorie12);

                // Livraison

                $Livraison1 = new Livraison();
                $Livraison1->setTitre("Standard");
                $Livraison1->setDescriptif("2 à 3 jours ouvrés");
                $Livraison1->setPrix(8900);
                $manager->persist($Livraison1);

                $Livraison2 = new Livraison();
                $Livraison2->setTitre("Express");
                $Livraison2->setDescriptif("24 h");
                $Livraison2->setPrix(14900);
                $manager->persist($Livraison2);



                // PRODUITS
       for ($i=1 ; $i < 240 ; $i++ ) { 
            $produit = new Produit();
            $produit ->setNom($this->faker->word())
                ->setDescription($this->faker->text(200))
                ->setPrix(mt_rand(100, 500000))
                ->setStock(mt_rand(0, 1000))
                ->setActif(mt_rand(0, 1) == 1 ? true : false );
            $randomSousCategorie = $this->faker->randomElement([$SousCategorie1, $SousCategorie2, $SousCategorie3, $SousCategorie4, $SousCategorie5, $SousCategorie6, $SousCategorie7, $SousCategorie8, $SousCategorie9, $SousCategorie10, $SousCategorie11, $SousCategorie12]);
            $produit->setSousCategorie($randomSousCategorie);
            
            $manager->persist($produit);
       }

            /// Générer des adresses uniques pour chaque utilisateur
        $addresses = [];
        foreach ($users as $user) {
            for ($i = 0; $i < 2; $i++) {
                $adresse = new Adresse();
                $adresse->setTitre('Mon domicile');
                $adresse->setSociete('');
                $adresse->setNom($this->faker->word(1, true));
                $adresse->setPrenom($this->faker->word(1, true));
                $adresse->setAdresse($this->faker->streetAddress());
                $adresse->setVille($this->faker->city());
                $adresse->setCodePostal(str_replace(' ', '', $this->faker->postcode));
                $adresse->setPays($this->faker->country());
                $adresse->setTelephone('00.00.00.00.00');
                $adresse->setUser($user); // Affecter l'utilisateur à l'adresse
                $addresses[] = $adresse;
                $manager->persist($adresse);
            }
        }

        // Affecter les adresses précédemment créées aux utilisateurs
        foreach ($addresses as $adresse) {
            $adresse->getUser()->addAdresse($adresse);
        }


        $manager->flush();
    }
}
