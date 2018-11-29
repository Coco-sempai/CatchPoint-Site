<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity
 */
class Utilisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=50, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=50, nullable=false)
     */
    private $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_utilisateur", type="string", length=50, nullable=false)
     */
    private $nomUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_utilisateur", type="string", length=50, nullable=false)
     */
    private $prenomUtilisateur;

    /**
     * @var bool
     *
     * @ORM\Column(name="droit_admin", type="boolean", nullable=false,options={"default"=false})
     */
    private $droitAdmin=0;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Parcours", mappedBy="idUtilisateur")
     */
    private $idParcours;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idParcours = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): self
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenomUtilisateur;
    }

    public function setPrenomUtilisateur(string $prenomUtilisateur): self
    {
        $this->prenomUtilisateur = $prenomUtilisateur;

        return $this;
    }

    public function getDroitAdmin(): ?bool
    {
        return $this->droitAdmin;
    }

    public function setDroitAdmin(bool $droitAdmin): self
    {
        $this->droitAdmin = $droitAdmin;

        return $this;
    }

    /**
     * @return Collection|Parcours[]
     */
    public function getIdParcours(): Collection
    {
        return $this->idParcours;
    }

    public function addIdParcour(Parcours $idParcour): self
    {
        if (!$this->idParcours->contains($idParcour)) {
            $this->idParcours[] = $idParcour;
            $idParcour->addIdUtilisateur($this);
        }

        return $this;
    }

    public function removeIdParcour(Parcours $idParcour): self
    {
        if ($this->idParcours->contains($idParcour)) {
            $this->idParcours->removeElement($idParcour);
            $idParcour->removeIdUtilisateur($this);
        }

        return $this;
    }

}
