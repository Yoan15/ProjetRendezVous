<?php

namespace App\Entity;

use App\Repository\PraticienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PraticienRepository::class)
 */
class Praticien
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Specialite::class, inversedBy="praticiens")
     */
    private $specialite;

    /**
     * @ORM\OneToMany(targetEntity=Patient::class, mappedBy="praticien")
     */
    private $patients;

    /**
     * @ORM\OneToMany(targetEntity=Rdv::class, mappedBy="praticien")
     */
    private $rdvs;

    public function __construct()
    {
        $this->patients = new ArrayCollection();
        $this->rdvs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * @return Collection|Patient[]
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients[] = $patient;
            $patient->setPraticien($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getPraticien() === $this) {
                $patient->setPraticien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rdv[]
     */
    public function getRdvs(): Collection
    {
        return $this->rdvs;
    }

    public function addRdv(Rdv $rdv): self
    {
        if (!$this->rdvs->contains($rdv)) {
            $this->rdvs[] = $rdv;
            $rdv->setPraticien($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): self
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getPraticien() === $this) {
                $rdv->setPraticien(null);
            }
        }

        return $this;
    }
}
