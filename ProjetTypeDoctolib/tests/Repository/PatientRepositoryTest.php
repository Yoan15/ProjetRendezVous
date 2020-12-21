<?php

namespace App\Tests\Repository;

use App\DataFixtures\AppFixtures;
use App\DataFixtures\PatientFixture;
use App\Entity\Patient;
use App\Repository\PatientRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientRepositoryTest extends KernelTestCase{
    use FixturesTrait;

    private $repository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->repository = self::$container->get(PatientRepository::class);
    }

    public function testFindAll(){
        $this->loadFixtures([PatientFixture::class]);
        $patients = $this->repository->findAll();
        $this->assertCount(5, $patients);
    }

    public function testFindBy(){
        $this->loadFixtures([PatientFixture::class]);
        $patients = $this->repository->findBy(["prenom" => "Jean 1"]);
        $this->assertCount(1, $patients);
    }

    public function testManagerPersist(){
        $this->loadFixtures([AppFixtures::class]);
        $patient = (new Patient())->setNom("Dufour")->setPrenom("Théo")->setNumSecuSociale(175846972548731);
        $manager = self::$container->get("doctrine.orm.default_entity_manager");
        $manager->persist($patient);
        $manager->flush();

        $this->assertCount(1, $this->repository->findAll());
    }
}