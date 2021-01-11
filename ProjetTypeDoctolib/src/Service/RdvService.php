<?php

namespace App\Service;

use App\DTO\RdvDTO;
use App\Entity\Rdv;
use App\Mapper\RdvMapper;
use App\Repository\RdvRepository;
use App\Repository\PatientRepository;
use App\Repository\PraticienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\RdvServiceException;

class RdvService{
    private $repository;
    private $entityManager;
    private $patientRepository;
    private $praticienRepository;
    private $rdvMapper;

    public function __construct(RdvRepository $repo, EntityManagerInterface $entityManager, PatientRepository $patientRepository, PraticienRepository $praticienRepository, 
                                RdvMapper $mapper)
    {
        $this->repository = $repo;
        $this->entityManager = $entityManager;
        $this->patientRepository = $patientRepository;
        $this->praticienRepository = $praticienRepository;
        $this->rdvMapper = $mapper;
    }

    public function searchAll(){
        try{
            $rdvs = $this->repository->findAll();
            $rdvDTOs = [];
            foreach($rdvs as $rdv){
                $rdvDTOs[] = $this->rdvMapper->transformeRdvEntityToRdvDto($rdv);
            }
            return $rdvDTOs;
        }catch(DriverException $e){
            throw new RdvServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.");
        }
    }

    public function delete(Rdv $rdv){
        try{
            $this->entityManager->remove($rdv);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new RdvServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.");
        }
    }

    public function persist(Rdv $rdv, RdvDTO $rdvDTO){
        try{
            $patient = $this->patientRepository->find($rdvDTO->getPatient());
            $praticien = $this->praticienRepository->find($rdvDTO->getPraticien());
            $rdv = $this->rdvMapper->transformeRdvDtoToRdvEntity($rdvDTO, $rdv, $patient, $praticien);
            $this->entityManager->persist($rdv);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new RdvServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.");
        }
    }

    public function searchbyId(int $id){
        try{
            $rdv = $this->repository->find($id);
            return $this->rdvMapper->transformeRdvEntityToRdvDto($rdv);
        }catch(DriverException $e){
            throw new RdvServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.", $e->getCode());
        }
    }
}

?>