<?php

namespace App\DataFixtures;

use App\Entity\Praticien;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PraticienFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <= 5; $i++){
            $praticien = (new Praticien())->setNom("Fernand $i")->setPrenom("Marcel $i")->setAdresse("10 Rue De La Maroquinnerie")->setEmail("DupondJean$i@gmail.com")->setPassword("kongo");
            $manager->persist($praticien);
        }
        $manager->flush();
    }
}
