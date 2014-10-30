<?php

namespace fascli\BdcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * dollar
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="fascli\BdcBundle\Repository\dollarRepository")
 */
class dollar
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
     * @ORM\ManyToOne(targetEntity="operationsbdc",inversedBy="dollars",cascade={"remove"})
     * @ORM\JoinColumn(name="operationsbdc_id", referencedColumnName="id")
     */
    private $operationbdc;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=1)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="val", type="integer")
     */
    private $val;

    /**
     * @var string
     *
     * @ORM\Column(name="qte", type="integer")
     */
    private $qte;

    
    /**
     * @var string
     *
     * @ORM\Column(name="remise", type="decimal")
     */
    private $remise;

    /**
     * @var string
     *
     * @ORM\Column(name="taux", type="decimal")
     */
    private $taux;

    /**
     * @var string
     *
     * @ORM\Column(name="tauxreel", type="decimal")
     */
    private $tauxreel;

    /**
     * @var string
     *
     * @ORM\Column(name="qterest", type="integer")
     */
    private $qterest;

    /**
     * @var string
     *
     * @ORM\Column(name="marge", type="decimal")
     */
    private $marge;



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
     * Set val
     *
     * @param integer $val
     * @return dollar
     */
    public function setVal($val)
    {
        $this->val = $val;

        return $this;
    }

    /**
     * Get val
     *
     * @return integer 
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * Set qte
     *
     * @param integer $qte
     * @return dollar
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return integer 
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Set remise
     *
     * @param string $remise
     * @return dollar
     */
    public function setRemise($remise)
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * Get remise
     *
     * @return string 
     */
    public function getRemise()
    {
        return $this->remise;
    }

    /**
     * Set taux
     *
     * @param string $taux
     * @return dollar
     */
    public function setTaux($taux)
    {
        $this->taux = $taux;

        return $this;
    }

    /**
     * Get taux
     *
     * @return string 
     */
    public function getTaux()
    {
        return $this->taux;
    }

    /**
     * Set tauxreel
     *
     * @param string $tauxreel
     * @return dollar
     */
    public function setTauxreel($tauxreel)
    {
        $this->tauxreel = $tauxreel;

        return $this;
    }

    /**
     * Get tauxreel
     *
     * @return string 
     */
    public function getTauxreel()
    {
        return $this->tauxreel;
    }

    /**
     * Set qterest
     *
     * @param integer $qterest
     * @return dollar
     */
    public function setQterest($qterest)
    {
        $this->qterest = $qterest;

        return $this;
    }

    /**
     * Get qterest
     *
     * @return integer 
     */
    public function getQterest()
    {
        return $this->qterest;
    }

    /**
     * Set marge
     *
     * @param string $marge
     * @return dollar
     */
    public function setMarge($marge)
    {
        $this->marge = $marge;

        return $this;
    }

    /**
     * Get marge
     *
     * @return string 
     */
    public function getMarge()
    {
        return $this->marge;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return dollar
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
     * Set operationbdc
     *
     * @param \fascli\BdcBundle\Entity\operationsbdc $operationbdc
     * @return dollar
     */
    public function setOperationbdc(\fascli\BdcBundle\Entity\operationsbdc $operationbdc = null)
    {
        $this->operationbdc = $operationbdc;

        return $this;
    }

    /**
     * Get operationbdc
     *
     * @return \fascli\BdcBundle\Entity\operationsbdc 
     */
    public function getOperationbdc()
    {
        return $this->operationbdc;
    }
}
