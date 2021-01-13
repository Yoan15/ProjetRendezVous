<?php

namespace App\DTO;

/**
 * @OA\Schema()
 */
class PatientDTO{
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
    private $nom;
    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $prenom;
    /**
     * @OA\Property(type="integer")
     *
     * @var int
     */
    private $num_secu_sociale;
    /**
     * @OA\Property(type="integer")
     *
     * @var int
     */
    private $praticien;
    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $email;
    private $role;
    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $password;
    /**
    * @OA\Property(type="string")
    *
    * @var date
    */
    private $birthday;
    /**
     * @OA\Property(type="string")
     *
     * @var string
     */
    private $adresse;

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
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of num_secu_sociale
     */ 
    public function getNumSecuSociale()
    {
        return $this->num_secu_sociale;
    }

    /**
     * Set the value of num_secu_sociale
     *
     * @return  self
     */ 
    public function setNumSecuSociale($num_secu_sociale)
    {
        $this->num_secu_sociale = $num_secu_sociale;

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

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of birthday
     */ 
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set the value of birthday
     *
     * @return  self
     */ 
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get the value of adresse
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }
}

?>