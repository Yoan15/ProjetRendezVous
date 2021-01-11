<?php

namespace App\Mapper;

use App\DTO\PraticienDTO;
use App\Entity\Praticien;
use App\Entity\Specialite;

class PraticienMapper {

    public function transformePraticienDtoToPraticienEntity(PraticienDTO $praticienDto, Praticien $praticien, Specialite $specialite){
        $praticien->setNom($praticienDto->getNom());
        $praticien->setPrenom($praticienDto->getPrenom());
        $praticien->setAdresse($praticienDto->getAdresse());
        $praticien->setSpecialite($specialite);
        $praticien->setEmail($praticienDto->getEmail());
        $praticien->setPassword($praticienDto->getPassword());
        return $praticien;
    }

    public function transformePraticienEntityToPraticienDto(Praticien $praticien){
        $praticienDto = new PraticienDTO();
        $praticienDto->setId($praticien->getId());
        $praticienDto->setNom($praticien->getNom());
        $praticienDto->setPrenom($praticien->getPrenom());
        $praticienDto->setAdresse($praticien->getAdresse());
        $praticienDto->setSpecialite($praticien->getSpecialite()->getId());
        $praticienDto->setEmail($praticien->getEmail());
        $praticienDto->setPassword($praticien->getPassword());
        return $praticienDto;
    }
}

?>