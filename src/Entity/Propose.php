<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Propose
 *
 * @ORM\Table(name="propose", indexes={@ORM\Index(name="Propose_Parcours0_FK", columns={"id_parcours"}), @ORM\Index(name="Propose_Date1_FK", columns={"date_enregistre"}), @ORM\Index(name="IDX_3DF2D06050EAE44", columns={"id_utilisateur"})})
 * @ORM\Entity
 */
class Propose
{
    /**
     * @var \DateTable
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="DateTable")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="date_enregistre", referencedColumnName="date_enregistre")
     * })
     */
    private $dateEnregistre;

    /**
     * @var \Parcours
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Parcours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_parcours", referencedColumnName="id_parcours")
     * })
     */
    private $idParcours;

    /**
     * @var \Utilisateur
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id_utilisateur")
     * })
     */
    private $idUtilisateur;

    public function getDateEnregistre(): ?DateTable
    {
        return $this->dateEnregistre;
    }

    public function setDateEnregistre(?DateTable $dateEnregistre): self
    {
        $this->dateEnregistre = $dateEnregistre;

        return $this;
    }

    public function getIdParcours(): ?Parcours
    {
        return $this->idParcours;
    }

    public function setIdParcours(?Parcours $idParcours): self
    {
        $this->idParcours = $idParcours;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }


}
