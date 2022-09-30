<?php

namespace App\DataFixtures;

use App\Entity\Employes;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EmployesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ( $i = 1; $i < 10; $i++ ) {
            $employes = new Employes;

            $employes->setPrenom(" Prénom employé n°$i")
                     ->setNom("Nom employé n°$i")            
                     ->setTelephone("063459215$i")            
                     ->setEmail("email$i@gmail.com")            
                     ->setAdresse("0$i rue Rivoli")            
                     ->setPoste("Commercial")            
                     ->setSalaire(20000)            
                     ->setDateNaissance(new \DateTime("12/01/198$i"))            
            ;
            $manager->persist($employes);
        }

        $manager->flush();
    }
}
