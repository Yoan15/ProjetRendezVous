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

}