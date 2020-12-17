<?php

namespace App\Tests\Entity;

use App\Entity\Praticien;
use App\Entity\Specialite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SpecialiteTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getSpecialite(string $nomSpe = null){
        $specialite = (new Specialite())->setNomSpecialite($nomSpe);
        return $specialite;
    }

    public function testGetterAndSetterNomSpecialite(){
        $specialite = $this->getSpecialite("Chirurgie");
        $this->assertEquals("Chirurgie", $specialite->getNomSpecialite(), "Echec sur le test : 'testGetterAndSetterNomSpecialite'.");
    }

    public function testIsSpecialiteValid(){
        $specialite = $this->getSpecialite("Chirurgie");
        $errors = $this->validator->validate($specialite);
        $this->assertCount(0, $errors, "Echec sur le test : 'testIsSpecialiteValid'.");
    }

    public function testNotValidBlankSpecialite(){
        $specialite = $this->getSpecialite("");
        $errors = $this->validator->validate($specialite);
        $this->assertCount(1, $errors);
        // $this->assertEquals("La spécialité est obligatoire.", $errors[0]->getMessage(), "Echec sur le test : 'testNotValidBlankSpecialite'.");
    }

    public function testGetEmptyPraticiens(){
        $specialite = $this->getSpecialite("Chirurgie");
        $this->assertCount(0, $specialite->getPraticiens());
    }

    public function testGetNotEmptyPraticiens(){
        $specialite = $this->getSpecialite("Chirurgie");
        $praticien = (new Praticien())->setNom("Fernand")->setPrenom("Marcel")->setAdresse("10 Rue de La Maroquinerie");
        $specialite->addPraticien($praticien);
        $this->assertCount(1, $specialite->getPraticiens());
        $this->assertEquals($specialite, $praticien->getSpecialite());
    }

    public function testRemovePraticien(){
        $specialite = $this->getSpecialite("Chirurgie");
        $praticien = (new Praticien())->setNom("Fernand")->setPrenom("Marcel")->setAdresse("10 Rue de La Maroquinerie");
        $specialite->addPraticien($praticien);
        $this->assertCount(1, $specialite->getPraticiens());
        $specialite->removePraticien($praticien);
        $this->assertEquals(null, $praticien->getSpecialite());
    }
}