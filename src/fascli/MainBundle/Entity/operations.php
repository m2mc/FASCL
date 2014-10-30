<?php

namespace fascli\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * operations
 *
 * @ORM\Table(name="operations")
 * @ORM\Entity(repositoryClass="fascli\MainBundle\Repository\operationsRepository")
 */
class operations
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
     * @ORM\Column(name="datope", type="datetime")
     */
    private $datope;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=10)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="piece", type="string", length=100)
     */
    private $piece;

    /**
     * @var string
     *
     * @ORM\Column(name="npiece", type="string", length=100)
     */
    private $npiece;

    /**
     * @var string
     *
     * @ORM\Column(name="expdate", type="date")
     */
    private $expdate;

    /**
     * @ORM\ManyToOne(targetEntity="client",inversedBy="operation",cascade={"remove"})
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="caissier", type="string", length=100)
     */
    private $caissier;
/**
     * @var string
     *
     * @ORM\Column(name="cashpoint", type="string", length=100)
     */
    private $cashpoint;

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
     * Set datope
     *
     * @param \DateTime $datope
     * @return operations
     */
    public function setDatope($datope)
    {
        $this->datope = $datope;

        return $this;
    }

    /**
     * Get datope
     *
     * @return \DateTime 
     */
    public function getDatope()
    {
        return $this->datope;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return operations
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set montant
     *
     * @param integer $montant
     * @return operations
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
     * Set piece
     *
     * @param string $piece
     * @return operations
     */
    public function setPiece($piece)
    {
        $this->piece = $piece;

        return $this;
    }

    /**
     * Get piece
     *
     * @return string 
     */
    public function getPiece()
    {
        return $this->piece;
    }

    /**
     * Set npiece
     *
     * @param string $npiece
     * @return operations
     */
    public function setNpiece($npiece)
    {
        $this->npiece = $npiece;

        return $this;
    }

    /**
     * Get npiece
     *
     * @return string 
     */
    public function getNpiece()
    {
        return $this->npiece;
    }

    /**
     * Set client
     *
     * @param string $client
     * @return operations
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set caissier
     *
     * @param string $caissier
     * @return operations
     */
    public function setCaissier($caissier)
    {
        $this->caissier = $caissier;

        return $this;
    }

    /**
     * Get caissier
     *
     * @return string 
     */
    public function getCaissier()
    {
        return $this->caissier;
    }

    /**
     * Set expdate
     *
     * @param \DateTime $expdate
     * @return operations
     */
    public function setExpdate($expdate)
    {
        $this->expdate = $expdate;

        return $this;
    }

    /**
     * Get expdate
     *
     * @return \DateTime 
     */
    public function getExpdate()
    {
        return $this->expdate;
    }

    /**
     * Set cashpoint
     *
     * @param string $cashpoint
     * @return operations
     */
    public function setCashpoint($cashpoint)
    {
        $this->cashpoint = $cashpoint;

        return $this;
    }

    /**
     * Get cashpoint
     *
     * @return string 
     */
    public function getCashpoint()
    {
        return $this->cashpoint;
    }
}
