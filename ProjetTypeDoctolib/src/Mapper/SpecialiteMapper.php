<?php

namespace App\Mapper;

use App\DTO\SpecialiteDTO;
use App\Entity\Specialite;

class SpecialiteMapper{
    public function transformeSpecialiteDtoToSpecialiteEntity(SpecialiteDTO $specialiteDto, Specialite $specialite){
        $specialite->setNomSpecialite($specialiteDto->getNomSpecialite());
        return $specialite;
    }

    public function transformeSpecialiteEntityToSpecialiteDto(Specialite $specialite){
        $specialiteDto = new SpecialiteDTO();
        $specialiteDto->setId($specialite->getId());
        $specialiteDto->setNomSpecialite($specialite->getNomspecialite());
        return $specialiteDto;
    }
}

?>