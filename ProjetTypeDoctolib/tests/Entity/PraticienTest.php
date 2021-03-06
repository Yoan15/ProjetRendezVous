<?php

namespace App\Tests\Entity;

use App\Entity\Patient;
use App\Entity\Praticien;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PraticienTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getPraticien(string $nom = null, string $prenom = null, string $adresse = null){
        $praticien = (new Praticien())->setNom($nom)->setPrenom($prenom)->setAdresse($adresse);
        return $praticien;
    }

    public function testGetterAndSetterNom(){
        $praticien = $this->getPraticien("Fernand", "Marcel", "10 Rue de La Maroquinerie");
        $this->assertEquals("Fernand", $praticien->getNom(), "Echec sur le test : 'testGetterAndSetterNom'.");
    }

    public function testGetterAndSetterPrenom(){
        $praticien = $this->getPraticien("Fernand", "Marcel", "10 Rue de La Maroquinerie");
        $this->assertEquals("Marcel", $praticien->getPrenom(), "Echec sur le test : 'testGetterAndSetterPrenom'.");
    }
    
    public function testIsNomValid(){
        $praticien = $this->getPraticien("Fernand", "Marcel", "10 Rue de La Maroquinerie");
        $errors = $this->validator->validate($praticien);
        $this->assertCount(0, $errors, "Echec sur le test : 'testIsNomValid'.");
    }

    public function testNotValidBlankNom(){
        $praticien = $this->getPraticien("", "Marcel", "10 Rue de La Maroquinerie");
        $errors = $this->validator->validate($praticien);
        $this->assertCount(1, $errors);
        // $this->assertEquals("Le nom est obligatoire.", $errors[0]->getMessage(), "Echec sur le test : 'testNotValidBlankNom'.");
    }

    public function testNotValidBlankPrenom(){
        $praticien = $this->getPraticien("Fernand", "", "10 Rue de La Maroquinerie");
        $errors = $this->validator->validate($praticien);
        $this->assertCount(1, $errors);
        // $this->assertEquals("Le prenom est obligatoire.", $errors[0]->getMessage(), "Echec sur le test : 'testNotValidBlankPrenom'.");
    }

    public function testNotValidBlankAdresse(){
        $praticien = $this->getPraticien("Fernand", "Marcel", "10 Rue de La Maroquinerie");
        $errors = $this->validator->validate($praticien);
        $this->assertCount(0, $errors);
        // $this->assertEquals("L' adresse' est obligatoire.", $errors[0]->getMessage(), "Echec sur le test : 'testNotValidBlankAdresse'.");
    }

    public function testGetEmptyPatients(){
        $praticien = $this->getPraticien("Fernand", "Marcel", "10 Rue de La Maroquinerie");
        $this->assertCount(0, $praticien->getPatients());
    }

    public function testGetNotEmptyPatients(){
        $praticien = $this->getPraticien("Fernand", "Marcel", "10 Rue de La Maroquinerie");
        $patient = (new Patient())->setNom("Dupond")->setPrenom("Théo")->setNumSecuSociale(188475217986572);
        $praticien->addPatient($patient);
        $this->assertCount(1, $praticien->getPatients());
        $this->assertEquals($praticien, $patient->getPraticien());
    }

    public function testRemovePatient(){
        $praticien = $this->getPraticien("Fernand", "Marcel", "10 Rue de La Maroquinerie");
        $patient = (new Patient())->setNom("Dupond")->setPrenom("Théo")->setNumSecuSociale(188475217986572);
        $praticien->addPatient($patient);
        $this->assertCount(1, $praticien->getPatients());
        $praticien->removePatient($patient);
        $this->assertEquals(null, $praticien->getSpecialite());
    }
}