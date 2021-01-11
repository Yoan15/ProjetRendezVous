<?php

namespace App\Mapper;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Entity\Praticien;

class PatientMapper{
    public function transformePatientDtoToPatientEntity(PatientDTO $patientDto, Patient $patient, Praticien $praticien){
        $patient->setNom($patientDto->getNom());
        $patient->setPrenom($patientDto->getPrenom());
        $patient->setNumSecuSociale($patientDto->getNumSecuSociale());
        $patient->setPraticien($praticien);
        $patient->setEmail($patientDto->getEmail());
        $patient->setPassword($patientDto->getPassword());
        return $patient;
    }

    public function transformePatientEntityToPatientDto(Patient $patient){
        $patientDto = new PatientDTO();
        $patientDto->setId($patient->getId());
        $patientDto->setNom($patient->getNom());
        $patientDto->setPrenom($patient->getPrenom());
        $patientDto->setNumSecuSociale($patient->getNumSecuSociale());
        $patientDto->setPraticien($patient->getPraticien()->getId());
        $patientDto->setEmail($patient->getEmail());
        $patientDto->setPassword($patient->getPassword());
        return $patientDto;
    }
}

?>