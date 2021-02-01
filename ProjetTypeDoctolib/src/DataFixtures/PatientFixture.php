<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PatientFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <= 5; $i++){
            $patient = (new Patient())->setNom("Dupond $i")->setPrenom("Jean $i")->setNumSecuSociale(184571478298572)->setEmail("DupondJean$i@gmail.com")->setPassword("kongo")->setBirthday(\DateTime::createFromFormat('Y-m-d', "1999-08-19"))->setAdresse("75 Rue de la Montagne");
            $manager->persist($patient);
        }

        $manager->flush();
    }
}
