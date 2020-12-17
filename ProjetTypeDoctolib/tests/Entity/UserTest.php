<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase{
    private $validator;

    protected function setUp(){
        self::bootKernel();
        $this->validator = self::$container->get("validator");
    }

    private function getUser(string $email = null, string $password = null){
        $user = (new User())->setEmail($email)->setPassword($password);
        return $user;
    }

    public function testGetterAndSetterEmail(){
        $user = $this->getUser("P.Dumats@email.com", "PetitPain0928");
        $this->assertEquals("P.Dumats@email.com", $user->getEmail(), "Echec sur le test : 'testGetterAndSetterEmail'.");
    }

    public function testGetterAndSetterPassword(){
        $user = $this->getUser("P.Dumats@email.com", "PetitPain0928");
        $this->assertEquals("PetitPain0928", $user->getPassword(), "Echec sur le test : 'testGetterAndSetterNom'.");
    }
    
    public function testIsEmailValid(){
        $user = $this->getUser("P.Dumats@email.com", "PetitPain0928");
        $errors = $this->validator->validate($user);
        $this->assertCount(0, $errors, "Echec sur le test : 'testIsEmailValid'.");
    }

    public function testNotValidBlankEmail(){
        $user = $this->getUser("", "PetitPain0928");
        $errors = $this->validator->validate($user);
        $this->assertCount(1, $errors);
        // $this->assertEquals("L' email est obligatoire.", $errors[0]->getMessage(), "Echec sur le test : 'testNotValidBlankEmail'.");
    }

    public function testNotValidBlankPassword(){
        $user = $this->getUser("P.Dumats@email.com", "");
        $errors = $this->validator->validate($user);
        $this->assertCount(1, $errors);
        // $this->assertEquals("Le mot de passe est obligatoire.", $errors[0]->getMessage(), "Echec sur le test : 'testNotValidBlankPassword'.");
    }
}