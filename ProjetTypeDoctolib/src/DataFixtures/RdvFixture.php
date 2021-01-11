<?php

    namespace App\DataFixtures;

    use App\Entity\Rdv;
    use Doctrine\Persistence\ObjectManager;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use DateTime;

    class RdvFixture extends Fixture
    {
        public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $date = new DateTime("2020-12-17");
        $heure = new DateTime("15:30");
        for ($i = 1; $i <= 5; $i++){
            $rdv = (new Rdv())->setDate($date)->setHeure($heure);
            $manager->persist($rdv);
        }
        $manager->flush();
    }
    }

?>