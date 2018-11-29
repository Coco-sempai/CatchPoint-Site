<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DateTable
 *
 * @ORM\Table(name="date_table")
 * @ORM\Entity
 */
class DateTable
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_enregistre", type="date", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $dateEnregistre;

    public function getDateEnregistre(): ?\DateTimeInterface
    {
        return $this->dateEnregistre;
    }


}
