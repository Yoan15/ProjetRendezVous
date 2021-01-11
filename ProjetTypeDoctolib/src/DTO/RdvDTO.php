<?php

namespace App\DTO;

class RdvDTO{
    private $id;
    private $date;
    private $heure;
    private $patient;
    private $praticien;
    

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
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of heure
     */ 
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * Set the value of heure
     *
     * @return  self
     */ 
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get the value of patient
     */ 
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * Set the value of patient
     *
     * @return  self
     */ 
    public function setPatient($patient)
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get the value of praticien
     */ 
    public function getPraticien()
    {
        return $this->praticien;
    }

    /**
     * Set the value of praticien
     *
     * @return  self
     */ 
    public function setPraticien($praticien)
    {
        $this->praticien = $praticien;

        return $this;
    }
}

?>