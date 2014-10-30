<?php

namespace fascli\BdcBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * taux
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="fascli\BdcBundle\Repository\tauxRepository")
 */
class taux
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
     * @var string
     *
     * @ORM\Column(name="EA", type="decimal")
     */
    private $EA;

    /**
     * @var string
     *
     * @ORM\Column(name="EV", type="decimal")
     */
    private $EV;

    /**
     * @var string
     *
     * @ORM\Column(name="DA", type="decimal")
     */
    private $DA;

    /**
     * @var string
     *
     * @ORM\Column(name="DV", type="decimal")
     */
    private $DV;

    /**
     * @var string
     *
     * @ORM\Column(name="GA", type="decimal")
     */
    private $GA;

    /**
     * @var string
     *
     * @ORM\Column(name="GV", type="decimal")
     */
    private $GV;

    /**
     * @var string
     *
     * @ORM\Column(name="SA", type="decimal")
     */
    private $SA;

    /**
     * @var string
     *
     * @ORM\Column(name="SV", type="decimal")
     */
    private $SV;


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
     * Set EA
     *
     * @param string $eA
     * @return taux
     */
    public function setEA($eA)
    {
        $this->EA = $eA;

        return $this;
    }

    /**
     * Get EA
     *
     * @return string 
     */
    public function getEA()
    {
        return $this->EA;
    }

    /**
     * Set EV
     *
     * @param string $eV
     * @return taux
     */
    public function setEV($eV)
    {
        $this->EV = $eV;

        return $this;
    }

    /**
     * Get EV
     *
     * @return string 
     */
    public function getEV()
    {
        return $this->EV;
    }

    /**
     * Set DA
     *
     * @param string $dA
     * @return taux
     */
    public function setDA($dA)
    {
        $this->DA = $dA;

        return $this;
    }

    /**
     * Get DA
     *
     * @return string 
     */
    public function getDA()
    {
        return $this->DA;
    }

    /**
     * Set DV
     *
     * @param string $dV
     * @return taux
     */
    public function setDV($dV)
    {
        $this->DV = $dV;

        return $this;
    }

    /**
     * Get DV
     *
     * @return string 
     */
    public function getDV()
    {
        return $this->DV;
    }

    /**
     * Set GA
     *
     * @param string $gA
     * @return taux
     */
    public function setGA($gA)
    {
        $this->GA = $gA;

        return $this;
    }

    /**
     * Get GA
     *
     * @return string 
     */
    public function getGA()
    {
        return $this->GA;
    }

    /**
     * Set GV
     *
     * @param string $gV
     * @return taux
     */
    public function setGV($gV)
    {
        $this->GV = $gV;

        return $this;
    }

    /**
     * Get GV
     *
     * @return string 
     */
    public function getGV()
    {
        return $this->GV;
    }

    /**
     * Set SA
     *
     * @param string $sA
     * @return taux
     */
    public function setSA($sA)
    {
        $this->SA = $sA;

        return $this;
    }

    /**
     * Get SA
     *
     * @return string 
     */
    public function getSA()
    {
        return $this->SA;
    }

    /**
     * Set SV
     *
     * @param string $sV
     * @return taux
     */
    public function setSV($sV)
    {
        $this->SV = $sV;

        return $this;
    }

    /**
     * Get SV
     *
     * @return string 
     */
    public function getSV()
    {
        return $this->SV;
    }
}
