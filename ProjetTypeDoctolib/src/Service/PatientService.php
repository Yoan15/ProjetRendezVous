<?php

namespace App\Service;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Mapper\PatientMapper;
use App\Repository\PatientRepository;
use App\Repository\PraticienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\DriverException;
use App\Service\Exception\PatientServiceException;

class PatientService{
    private $repository;
    private $entityManager;
    private $praticienRepository;
    private $patientMapper;

    public function __construct(PatientRepository $repo, EntityManagerInterface $entityManager, PraticienRepository $praticienRepository, PatientMapper $mapper)
    {
        $this->repository = $repo;
        $this->entityManager = $entityManager;
        $this->praticienRepository = $praticienRepository;
        $this->patientMapper = $mapper;
    }

    public function searchAll(){
        try{
            $patients = $this->repository->findAll();
            $patientDTOs = [];
            foreach($patients as $patient) {
                $patientDTOs[] = $this->patientMapper->transformePatientEntityToPatientDto($patient);
            }
            return $patientDTOs;
        }catch(DriverException $e){
            throw new PatientServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function delete(Patient $patient){
        try{
            $this->entityManager->remove($patient);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new PatientServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function persist(Patient $patient, PatientDTO $patientDTO){
        try{
            $praticien = $this->praticienRepository->find($patientDTO->getPraticien());
            $patient = $this->patientMapper->transformePatientDtoToPatientEntity($patientDTO, $patient, $praticien);
            $this->entityManager->persist($patient);
            $this->entityManager->flush();
        }catch(DriverException $e){
            throw new PatientServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.", $e->getCode());
        }
    }

    public function searchbyId(int $id){
        try{
            $patient = $this->repository->find($id);
            return $this->patientMapper->transformePatientEntityToPatientDto($patient);
        }catch(DriverException $e){
            throw new PatientServiceException("Un problème technique est survenu. Veuillez réessayer ultérieurement.", $e->getCode());
        }
    }
}

?>