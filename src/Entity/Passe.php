<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Passe
 *
 * @ORM\Table(name="passe", indexes={@ORM\Index(name="Passe_Point0_FK", columns={"id_point"}), @ORM\Index(name="Passe_Date1_FK", columns={"date_enregistre"}), @ORM\Index(name="IDX_D317EE5F50EAE44", columns={"id_utilisateur"})})
 * @ORM\Entity
 */
class Passe
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
     * @var \Points
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Points")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_point", referencedColumnName="id_point")
     * })
     */
    private $idPoint;

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

    public function getIdPoint(): ?Points
    {
        return $this->idPoint;
    }

    public function setIdPoint(?Points $idPoint): self
    {
        $this->idPoint = $idPoint;

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
