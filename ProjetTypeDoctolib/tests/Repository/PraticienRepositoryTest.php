<?php

namespace App\Tests\Repository;

use App\DataFixtures\AppFixtures;
use App\DataFixtures\PraticienFixture;
use App\Entity\Praticien;
use App\Repository\PraticienRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PraticienRepositoryTest extends KernelTestCase{
    use FixturesTrait;

    private $repository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->repository = self::$container->get(PraticienRepository::class);
    }

    public function testFindAll(){
        $this->loadFixtures([PraticienFixture::class]);
        $praticiens = $this->repository->findAll();
        $this->assertCount(5, $praticiens);
    }

    public function testFindBy(){
        $this->loadFixtures([PraticienFixture::class]);
        $praticiens = $this->repository->findBy(["prenom" => "Marcel 1"]);
        $this->assertCount(1, $praticiens);
    }

    public function testManagerPersist(){
        $this->loadFixtures([AppFixtures::class]);
        $praticien = (new Praticien())->setNom("Duroche")->setPrenom("Jacques")->setAdresse("18 Rue des Jonquilles");
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($praticien);
        $manager->flush();

        $this->assertCount(1, $this->repository->findAll());
    }
}