<?php

namespace App\Service;

use App\DTO\SpecialiteDTO;
use App\Entity\Specialite;
use App\Mapper\SpecialiteMapper;
use App\Repository\SpecialiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\SpecialiteServiceException;

class SpecialiteService{
    private $repository;
    private $entityManager;
    private $specialiteMapper;

    public function __construct(SpecialiteRepository $repo, EntityManagerInterface $entityManager, SpecialiteMapper $mapper)
    {
        $this->repository = $repo;
        $this->entityManager = $entityManager;
        $this->specialiteMapper = $mapper;
    }

    public function searchAll(){
        try{
            $specialites = $this->repository->findAll();
            $specialiteDTOs = [];
            foreach ($specialites as $specialite) {
                $specialiteDTOs[] = $this->specialiteMapper->transformeSpecialiteEntityToSpecialiteDto($specialite);
            }
            return $specialiteDTOs;
        }catch (DriverException $e){
            throw new SpecialiteServiceException("Un problème technique est survenu. Veuillez réessayer plus tard.", $e->getCode());
        }
    }

    public function delete(Specialite $specialite){
        try{
            $this->entityManager->remove($specialite);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new SpecialiteServiceException("Un problème technique est survenu. Veuillez réessayer plus tard.", $e->getCode());
        }
    }

    public function persist(Specialite $specialite, SpecialiteDTO $specialiteDTO){
        try{
            $specialite = $this->specialiteMapper->transformeSpecialiteDtoToSpecialiteEntity($specialiteDTO, $specialite);
            $this->entityManager->persist($specialite);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new SpecialiteServiceException("Un problème technique est survenu. Veuillez réessayer plus tard.", $e->getCode());
        }
    }

    public function searchById(int $id){
        try{
            $specialite = $this->repository->find($id);
            return $this->specialiteMapper->transformeSpecialiteEntityToSpecialiteDto($specialite);
        }catch(DriverException $e){
            throw new SpecialiteServiceException("Un problème technique est survenu. Veuillez réessayer plus tard.", $e->getCode());
        }
    }
}

?>