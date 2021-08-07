<?php

namespace App\DataFixtures;

use App\Entity\Societe;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        
        $user = new User();

        //diri les info li bghiti
        $user->setEmail("hodajatte2000@gmail.com")
            ->setPassword($this->encoder->encodePassword($user, "hodajatte2000/01/12"))
            ->setNom("jatte")
            ->setPrenom("hoda")
            ->setAdresse("adresse rue 10 boulvard x nr 25")
        ;

        $manager->persist($user);


        for($i = 1; $i <= 10; $i++) {
            $societe = new Societe();
            $societe->setRaisonSociale($faker->word)
                    ->setSource($faker->word)
                    ->setFormeJuridique($faker->word)
                    ->setSecteurActivite($faker->word)
                    ->setSousSecteurActivite($faker->word)
                    ->setProduit($faker->word)
                    ->setOffreService($faker->word)
                    ->setDateCreation($faker->dateTime)
                    ->setGsm($faker->phoneNumber)
                    ->setEmail($faker->email)
                    ->setSiteInternet($faker->word)
            ;

            $manager->persist($societe);
        }




        $manager->flush();
    }
}
