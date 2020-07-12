<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Ville;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Role\Role;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $adminRole=new \App\Entity\Role();
        $adminRole->setTitre('ROLE_ADMIN');
        $manager->persist($adminRole);

        $ville = new Ville();
        $ville->setCodePostal(1160);
        $ville->setNom('Auderghem');
        $manager->persist($ville);

        $adminClient=new Client();
        $adminClient->setNom('Tounegang');
        $adminClient->setPrenom('Yannick');
        $adminClient->setSexe('H');
        $adminClient->setAdresse('rue de chambery 76');
        $adminClient->setEmail('yannicktchapda@yahoo.fr');
        $adminClient->setMotDePasse($this->encoder->encodePassword($adminClient, 'password'));
        $adminClient->setVille($ville);
        $adminClient->addUserRole($adminRole);
        // $product = new Product();
         $manager->persist($adminClient);

        $manager->flush();
    }
}