<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Cocur\Slugify\Slugify;

/**
 * Parcours
 *
 * @ORM\Table(name="parcours")
 * @ORM\Entity(repositoryClass="App\Repository\ParcoursRepository")
 * @UniqueEntity("nomParcours",message="Ce nom est déjà utilisé")
 */
class Parcours
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_parcours", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idParcours;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez remplir ce champ")
     * @ORM\Column(name="nom_parcours", type="string", length=50, nullable=false)
     */
    private $nomParcours;

    /**
     * @var float
     *
     * @ORM\Column(name="distance", type="float", precision=10, scale=0, nullable=false, options={"default"=5})
     */
    private $distance=5;

    /**
     * @var int
     *
     * @ORM\Column(name="difficulte", type="integer", nullable=false)
     */
    private $difficulte;

    /**
     * @var int
     *
     * @ORM\Column(name="duree", type="integer", nullable=false,options={"default"=5})
     */
    private $duree=5;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez remplir ce champ")
     * @Assert\Length(max="500")
     * @ORM\Column(name="description_parcours", type="string", length=50, nullable=false)
     */
    private $descriptionParcours;

    /**
     * @var string
     *
     * @ORM\Column(name="type_parcours", type="string", length=50, nullable=false,options={"default"=1})
     */
    private $typeParcours=1;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Points", inversedBy="idParcours")
     * @ORM\JoinTable(name="constitue",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_parcours", referencedColumnName="id_parcours")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_point", referencedColumnName="id_point")
     *   }
     * )
     */
    private $idPoint;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Utilisateur", inversedBy="idParcours")
     * @ORM\JoinTable(name="enregistre",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_parcours", referencedColumnName="id_parcours")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id_utilisateur")
     *   }
     * )
     */
    private $idUtilisateur;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idPoint = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idUtilisateur = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdParcours(): ?int
    {
        return $this->idParcours;
    }

    public function getNomParcours(): ?string
    {
        return $this->nomParcours;
    }

    public function getSlug(): string{
        return (new Slugify())->slugify($this->nomParcours);
    }

    public function setNomParcours(string $nomParcours): self
    {
        $this->nomParcours = $nomParcours;

        return $this;
    }

    public function getDistance(): ?float
    {
        return $this->distance;
    }

    public function setDistance(float $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getDifficulte(): ?int
    {
        return $this->difficulte;
    }

    public function setDifficulte(int $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDescriptionParcours(): ?string
    {
        return $this->descriptionParcours;
    }

    public function setDescriptionParcours(string $descriptionParcours): self
    {
        $this->descriptionParcours = $descriptionParcours;

        return $this;
    }

    public function getTypeParcours(): ?string
    {
        return $this->typeParcours;
    }

    public function setTypeParcours(string $typeParcours): self
    {
        $this->typeParcours = $typeParcours;

        return $this;
    }

    /**
     * @return Collection|Points[]
     */
    public function getIdPoint(): Collection
    {
        return $this->idPoint;
    }

    public function addIdPoint(Points $idPoint): self
    {
        if (!$this->idPoint->contains($idPoint)) {
            $this->idPoint[] = $idPoint;
        }

        return $this;
    }

    public function removeIdPoint(Points $idPoint): self
    {
        if ($this->idPoint->contains($idPoint)) {
            $this->idPoint->removeElement($idPoint);
        }

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getIdUtilisateur(): Collection
    {
        return $this->idUtilisateur;
    }

    public function addIdUtilisateur(Utilisateur $idUtilisateur): self
    {
        if (!$this->idUtilisateur->contains($idUtilisateur)) {
            $this->idUtilisateur[] = $idUtilisateur;
        }

        return $this;
    }

    public function removeIdUtilisateur(Utilisateur $idUtilisateur): self
    {
        if ($this->idUtilisateur->contains($idUtilisateur)) {
            $this->idUtilisateur->removeElement($idUtilisateur);
        }

        return $this;
    }

}
