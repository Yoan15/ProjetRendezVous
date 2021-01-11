<?php

namespace App\Mapper;

use DateTime;
use App\DTO\RdvDTO;
use App\Entity\Rdv;
use App\Entity\Patient;
use App\Entity\Praticien;

class RdvMapper{
    public function transformeRdvDtoToRdvEntity(RdvDTO $rdvDto, Rdv $rdv, Patient $patient, Praticien $praticien){
        $rdv->setDate(new DateTime($rdvDto->getDate()));
        $rdv->setHeure(new DateTime($rdvDto->getHeure()));
        $rdv->setPatient($patient);
        $rdv->setPraticien($praticien);
        return $rdv;
    }

    public function transformeRdvEntityToRdvDto(Rdv $rdv){
        $rdvDto = new RdvDTO();
        $rdvDto->setId($rdv->getId());
        $rdvDto->setDate($rdv->getDate()->format("d-m-Y"));
        $rdvDto->setHeure($rdv->getHeure()->format("H:i"));
        $rdvDto->setPatient($rdv->getPatient()->getId());
        $rdvDto->setPraticien($rdv->getPraticien()->getId());
        return $rdvDto;
    }
}

?>