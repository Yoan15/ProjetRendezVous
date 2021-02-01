<?php

    namespace App\DTO;
    use OpenApi\Annotations as OA;

/**
* @OA\Schema()
*/
    class SpecialiteDTO{
        /**
        * @OA\Property(type="integer")
        *
        * @var int
        */
        private $id;
        /**
        * @OA\Property(type="string")
        *
        * @var string
        */
        private $nom_specialite;


        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of nom_specialite
         */ 
        public function getNomSpecialite()
        {
                return $this->nom_specialite;
        }

        /**
         * Set the value of nom_specialite
         *
         * @return  self
         */ 
        public function setNomSpecialite($nom_specialite)
        {
                $this->nom_specialite = $nom_specialite;

                return $this;
        }
    }

?>