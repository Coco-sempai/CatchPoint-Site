<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Points
 *
 * @ORM\Table(name="points")
 * @ORM\Entity
 */
class Points
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_point", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPoint;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=false)
     */
    private $latitude;

    /**
     * @var bool
     *
     * @ORM\Column(name="depart", type="boolean", nullable=false)
     */
    private $depart;

    /**
     * @var bool
     *
     * @ORM\Column(name="arrive", type="boolean", nullable=false)
     */
    private $arrive;

    /**
     * @var string
     *
     * @ORM\Column(name="decription_point", type="string", length=50, nullable=false)
     */
    private $decriptionPoint;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Parcours", mappedBy="idPoint")
     */
    private $idParcours;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idParcours = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdPoint(): ?int
    {
        return $this->idPoint;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getDepart(): ?bool
    {
        return $this->depart;
    }

    public function setDepart(bool $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getArrive(): ?bool
    {
        return $this->arrive;
    }

    public function setArrive(bool $arrive): self
    {
        $this->arrive = $arrive;

        return $this;
    }

    public function getDecriptionPoint(): ?string
    {
        return $this->decriptionPoint;
    }

    public function setDecriptionPoint(string $decriptionPoint): self
    {
        $this->decriptionPoint = $decriptionPoint;

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
            $idParcour->addIdPoint($this);
        }

        return $this;
    }

    public function removeIdParcour(Parcours $idParcour): self
    {
        if ($this->idParcours->contains($idParcour)) {
            $this->idParcours->removeElement($idParcour);
            $idParcour->removeIdPoint($this);
        }

        return $this;
    }

}
