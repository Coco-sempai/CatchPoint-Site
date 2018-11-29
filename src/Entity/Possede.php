<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Possede
 *
 * @ORM\Table(name="possede", indexes={@ORM\Index(name="Possede_Commentaire0_FK", columns={"id_commentaire"}), @ORM\Index(name="Possede_Date1_FK", columns={"date_enregistre"}), @ORM\Index(name="IDX_3D0B1508C96A3276", columns={"id_parcours"})})
 * @ORM\Entity
 */
class Possede
{
    /**
     * @var \Commentaire
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Commentaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_commentaire", referencedColumnName="id_commentaire")
     * })
     */
    private $idCommentaire;

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

    public function getIdCommentaire(): ?Commentaire
    {
        return $this->idCommentaire;
    }

    public function setIdCommentaire(?Commentaire $idCommentaire): self
    {
        $this->idCommentaire = $idCommentaire;

        return $this;
    }

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


}
