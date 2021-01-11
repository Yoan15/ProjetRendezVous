<?php

    namespace App\DataFixtures;

    use App\Entity\Specialite;
    use Doctrine\Persistence\ObjectManager;
    use Doctrine\Bundle\FixturesBundle\Fixture;

    class SpecialiteFixture extends Fixture
    {
        public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <= 5; $i++){
            $specialite = (new Specialite())->setNomSpecialite("Specialité $i");
            $manager->persist($specialite);
        }
        $manager->flush();
    }
    }

?>