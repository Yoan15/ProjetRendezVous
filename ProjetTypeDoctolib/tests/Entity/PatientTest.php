<?php

namespace App\Tests\Entity;

use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getPatient(string $nom = null, string $prenom = null, int $numSecuSociale = null){
        $patient = (new Patient())->setNom($nom)->setPrenom($prenom)->setNumSecuSociale($numSecuSociale);
        return $patient;
    }

    public function testGetterAndSetterNom(){
        $patient = $this->getPatient("Fernand", "Marcel", 188475217986572);
        $this->assertEquals("Fernand", $patient->getNom(), "Echec sur le test : 'testGetterAndSetterNom'.");
    }

    public function testGetterAndSetterPrenom(){
        $patient = $this->getPatient("Fernand", "Marcel", 188475217986572);
        $this->assertEquals("Marcel", $patient->getPrenom(), "Echec sur le test : 'testGetterAndSetterPrenom'.");
    }
    
    public function testIsNomValid(){
        $patient = $this->getPatient("Fernand", "Marcel", 188475217986572);
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors, "Echec sur le test : 'testIsNomValid'.");
    }

    public function testNotValidBlankNom(){
        $patient = $this->getPatient("", "Marcel", 188475217986572);
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        // $this->assertEquals("Le nom est obligatoire.", $errors[0]->getMessage(), "Echec sur le test : 'testNotValidBlankNom'.");
    }

    public function testNotValidBlankPrenom(){
        $patient = $this->getPatient("Fernand", "", 188475217986572);
        $errors = $this->validator->validate($patient);
        $this->assertCount(1, $errors);
        // $this->assertEquals("Le prenom est obligatoire.", $errors[0]->getMessage(), "Echec sur le test : 'testNotValidBlankPrenom'.");
    }

    public function testNotValidBlankNumSecuSociale(){
        $patient = $this->getPatient("Fernand", "Marcel", 1);
        $errors = $this->validator->validate($patient);
        $this->assertCount(0, $errors);
        // $this->assertEquals("Le numéro de sécurité sociale est obligatoire.", $errors[0]->getMessage(), "Echec sur le test : 'testNotValidBlankNumSecuSociale'.");
    }
}