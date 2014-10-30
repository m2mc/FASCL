<?php

namespace fascli\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * commissions
 *
 * @ORM\Table(name="commissions")
 * @ORM\Entity(repositoryClass="fascli\MainBundle\Repository\commissionsRepository")
 */
class commissions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debutperiode", type="date")
     */
    private $debutperiode;

    /**
     * @var string
     *
     * @ORM\Column(name="finperiode", type="date")
     */
    private $finperiode;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="enregistreur", type="string", length=20)
     */
    private $enregistreur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datenr", type="datetime")
     */
    private $datenr;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set debutperiode
     *
     * @param \DateTime $debutperiode
     * @return commissions
     */
    public function setDebutperiode($debutperiode)
    {
        $this->debutperiode = $debutperiode;

        return $this;
    }

    /**
     * Get debutperiode
     *
     * @return \DateTime 
     */
    public function getDebutperiode()
    {
        return $this->debutperiode;
    }

    /**
     * Set finperiode
     *
     * @param string $finperiode
     * @return commissions
     */
    public function setFinperiode($finperiode)
    {
        $this->finperiode = $finperiode;

        return $this;
    }

    /**
     * Get finperiode
     *
     * @return string 
     */
    public function getFinperiode()
    {
        return $this->finperiode;
    }

    /**
     * Set montant
     *
     * @param integer $montant
     * @return commissions
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return integer 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set enregistreur
     *
     * @param string $enregistreur
     * @return commissions
     */
    public function setEnregistreur($enregistreur)
    {
        $this->enregistreur = $enregistreur;

        return $this;
    }

    /**
     * Get enregistreur
     *
     * @return string 
     */
    public function getEnregistreur()
    {
        return $this->enregistreur;
    }

    /**
     * Set datenr
     *
     * @param \DateTime $datenr
     * @return commissions
     */
    public function setDatenr($datenr)
    {
        $this->datenr = $datenr;

        return $this;
    }

    /**
     * Get datenr
     *
     * @return \DateTime 
     */
    public function getDatenr()
    {
        return $this->datenr;
    }
}
