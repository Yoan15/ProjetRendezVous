<?php

namespace App\Tests\Entity;

use App\Entity\Rdv;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RdvTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getRdv(\DateTimeInterface $date = null, \DateTimeInterface $heure = null){
        $rdv = (new Rdv())->setDate($date)->setHeure($heure);
        return $rdv;
    }

    public function testGetterAndSetterDate(){
        $date = new DateTime("2020-12-17");
        $heure = new DateTime("15:30");
        $rdv = $this->getRdv($date,$heure);
        $this->assertEquals($date, $rdv->getDate(), "Echec sur le test : 'testGetterAndSetterDate'.");
    }

    
}