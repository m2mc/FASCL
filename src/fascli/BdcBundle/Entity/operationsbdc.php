<?php

namespace fascli\BdcBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * operations
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="fascli\BdcBundle\Repository\operationsbdcRepository")
 */
class operationsbdc
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
     * @ORM\OneToMany(targetEntity="euro", mappedBy="operationbdc", cascade={"remove", "persist"})
     *   
     */
    private $euros;  

    /**
     * @ORM\OneToMany(targetEntity="dollar", mappedBy="operationbdc", cascade={"remove", "persist"})
     *   
     */
    private $dollars;  

    /**
     * @ORM\OneToMany(targetEntity="gbp", mappedBy="operationbdc", cascade={"remove", "persist"})
     *   
     */
    private $gbps;

    /**
     * @ORM\OneToMany(targetEntity="suisse", mappedBy="operationbdc", cascade={"remove", "persist"})
     *   
     */
    private $suisses;

    /**
     * @ORM\ManyToOne(targetEntity="fascli\MainBundle\Entity\client",inversedBy="operationsbdc",cascade={"remove"})
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datope", type="datetime")
     */
    private $datope;

    /**
     * @var string
     *
     * @ORM\Column(name="caissier", type="string", length=100)
     */
    private $caissier;

    /**
     * @var string
     *
     * @ORM\Column(name="agence", type="string", length=100)
     */
    private $agence;

    /**
     * @var string
     *
     * @ORM\Column(name="typope", type="string", length=10)
     */
    private $typope;

    /**
     * @var string
     *
     * @ORM\Column(name="devise", type="string", length=10)
     */
    private $devise;


    

    public function setEuros(ArrayCollection $euros)
    {
    foreach ($euros as $euro) {
        $euro->addOperationbdc($this);
    }

    $this->euros = $euros;
   }

   public function setDollars(ArrayCollection $dollars)
    {
    foreach ($dollars as $dollar) {
        $dollar->addOperationbdc($this);
    }

    $this->dollars = $dollars;
   }

   public function setGbps(ArrayCollection $gbps)
    {
    foreach ($gbps as $gbp) {
        $gbp->addOperationbdc($this);
    }

    $this->gbps = $gbps;
   }

   public function setSuisses(ArrayCollection $suisses)
    {
    foreach ($suisses as $suisse) {
        $suisse->addOperationbdc($this);
    }

    $this->suisses = $suisses;
   }



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->euros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dollars = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gbps = new \Doctrine\Common\Collections\ArrayCollection();
        $this->suisses = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return operationsbdc
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
     * Set caissier
     *
     * @param string $caissier
     * @return operationsbdc
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
     * Set agence
     *
     * @param string $agence
     * @return operationsbdc
     */
    public function setAgence($agence)
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * Get agence
     *
     * @return string 
     */
    public function getAgence()
    {
        return $this->agence;
    }

    /**
     * Set typope
     *
     * @param string $typope
     * @return operationsbdc
     */
    public function setTypope($typope)
    {
        $this->typope = $typope;

        return $this;
    }

    /**
     * Get typope
     *
     * @return string 
     */
    public function getTypope()
    {
        return $this->typope;
    }

    /**
     * Set devise
     *
     * @param string $devise
     * @return operationsbdc
     */
    public function setDevise($devise)
    {
        $this->devise = $devise;

        return $this;
    }

    /**
     * Get devise
     *
     * @return string 
     */
    public function getDevise()
    {
        return $this->devise;
    }

    /**
     * Add euros
     *
     * @param \fascli\BdcBundle\Entity\euro $euros
     * @return operationsbdc
     */
    public function addEuro(\fascli\BdcBundle\Entity\euro $euros)
    {
        $this->euros[] = $euros;
        $euros->setOperationbdc($this);
        return $this;
    }

    /**
     * Remove euros
     *
     * @param \fascli\BdcBundle\Entity\euro $euros
     */
    public function removeEuro(\fascli\BdcBundle\Entity\euro $euros)
    {
        $this->euros->removeElement($euros);
    }

    /**
     * Get euros
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEuros()
    {
        return $this->euros;
    }

    /**
     * Add dollars
     *
     * @param \fascli\BdcBundle\Entity\dollar $dollars
     * @return operationsbdc
     */
    public function addDollar(\fascli\BdcBundle\Entity\dollar $dollars)
    {
        $this->dollars[] = $dollars;
        $dollars->setOperationbdc($this);
        return $this;
    }

    /**
     * Remove dollars
     *
     * @param \fascli\BdcBundle\Entity\dollar $dollars
     */
    public function removeDollar(\fascli\BdcBundle\Entity\dollar $dollars)
    {
        $this->dollars->removeElement($dollars);
    }

    /**
     * Get dollars
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDollars()
    {
        return $this->dollars;
    }

    /**
     * Add gbps
     *
     * @param \fascli\BdcBundle\Entity\gbp $gbps
     * @return operationsbdc
     */
    public function addGbp(\fascli\BdcBundle\Entity\gbp $gbps)
    {
        $this->gbps[] = $gbps;
        $gbps->setOperationbdc($this);
        return $this;
    }

    /**
     * Remove gbps
     *
     * @param \fascli\BdcBundle\Entity\gbp $gbps
     */
    public function removeGbp(\fascli\BdcBundle\Entity\gbp $gbps)
    {
        $this->gbps->removeElement($gbps);
    }

    /**
     * Get gbps
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGbps()
    {
        return $this->gbps;
    }

    /**
     * Add suisses
     *
     * @param \fascli\BdcBundle\Entity\suisse $suisses
     * @return operationsbdc
     */
    public function addSuiss(\fascli\BdcBundle\Entity\suisse $suisses)
    {
        $this->suisses[] = $suisses;
        $suisses->setOperationbdc($this);
        return $this;
    }

    /**
     * Remove suisses
     *
     * @param \fascli\BdcBundle\Entity\suisse $suisses
     */
    public function removeSuiss(\fascli\BdcBundle\Entity\suisse $suisses)
    {
        $this->suisses->removeElement($suisses);
    }

    /**
     * Get suisses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSuisses()
    {
        return $this->suisses;
    }

    /**
     * Set client
     *
     * @param \fascli\MainBundle\Entity\client $client
     * @return operationsbdc
     */
    public function setClient(\fascli\MainBundle\Entity\client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \fascli\MainBundle\Entity\client 
     */
    public function getClient()
    {
        return $this->client;
    }
}
