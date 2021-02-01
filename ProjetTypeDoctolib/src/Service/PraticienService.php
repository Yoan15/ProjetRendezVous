<?php

namespace App\Service;

use App\DTO\PraticienDTO;
use App\Entity\Praticien;
use App\Mapper\PraticienMapper;
use App\Repository\PraticienRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\PraticienServiceException;

class PraticienService{

    private $repository;
    private $entityManager;
    private $specialiteRepository;
    private $praticienMapper;

    public function __construct(PraticienRepository $repo, EntityManagerInterface $entityManager, SpecialiteRepository $specialiteRepository, PraticienMapper $mapper)
    {
        $this->repository = $repo;
        $this->entityManager = $entityManager;
        $this->specialiteRepository = $specialiteRepository;
        $this->praticienMapper = $mapper;
    }

    public function searchAll(){
        try{
            $praticiens = $this->repository->findAll();
            $praticienDTOs = [];
            foreach($praticiens as $praticien){
                $praticienDTOs[] = $this->praticienMapper->transformePraticienEntityToPraticienDto($praticien);
            }
            return $praticienDTOs;
        }catch(DriverException $e){
            throw new PraticienServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.");
        }
    }

    public function delete(Praticien $praticien){
        try{
            $this->entityManager->remove($praticien);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new PraticienServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.");
        }
    }

    public function persist(Praticien $praticien, PraticienDTO $praticienDTO){
        try{
            $specialite = $this->specialiteRepository->find($praticienDTO->getSpecialite());
            $praticien = $this->praticienMapper->transformePraticienDtoToPraticienEntity($praticienDTO, $praticien, $specialite);
            $this->entityManager->persist($praticien);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new PraticienServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.");
        }
    }

    public function searchById(int $id){
        try{
            $praticien = $this->repository->find($id);
            return $this->praticienMapper->transformePraticienEntityToPraticienDto($praticien);
        }catch(DriverException $e){
            throw new PraticienServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.");
        }
    }

    public function searchBySpe(string $specialite){
        try{
            $praticiens = $this->repository->searchBySpe($specialite);
            $praticienDTOs = [];
            foreach($praticiens as $praticien){
                $praticienDTOs[] = $this->praticienMapper->transformePraticienEntityToPraticienDto($praticien);
            }
            return $praticienDTOs;
        }catch(DriverException $e){
            throw new PraticienServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.");
        }
    }
}

?>