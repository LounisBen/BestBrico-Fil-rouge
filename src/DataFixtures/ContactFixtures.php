<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Contact;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class ContactFixtures extends Fixture
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

        $contacts = [];

        for ($i=1; $i <= 20; $i++)
        { 
            $contact = new Contact();
            $contact->setNom($this->faker->name())
                ->setEmail($this->faker->email())
                ->setSujet('Demande n°' . ($i))
                ->setMessage($this->faker->text());
       
            $contacts[] = $contact;

            $manager->persist($contact);
        }

        $manager->flush();
    }
}