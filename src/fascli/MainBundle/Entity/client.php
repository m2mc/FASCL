<?php

namespace fascli\MainBundle\Entity;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;

/**
 * client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="fascli\MainBundle\Repository\clientRepository")
 * 
 */
class client
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     *
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenoms", type="string", length=255)
     *
     */
    private $prenoms;

    /**
     * @var string
     *
     * @ORM\Column(name="nomprenoms", type="string", length=255, unique=true)
     */
    private $nomprenoms;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datnaissance", type="date")
     */
    private $datnaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=5)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=50)
     */
    private $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=100)
     *
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=100)
     */
    private $profession;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=100)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="operations", mappedBy="client", cascade={"remove","persist"})
     */
    private $operation;

    /**
     * @ORM\OneToMany(targetEntity="fascli\BdcBundle\Entity\operationsbdc", mappedBy="client", cascade={"remove", "persist"})
     *   
     */
    private $operationsbdc;  

    /**
     * @var string
     *
     * @ORM\Column(name="caissier", type="string", length=100)
     */
    private $caissier;

    /**
     * @var string
     *
     * @ORM\Column(name="cashpoint", type="string", length=255)
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
     * Set nom
     *
     * @param string $nom
     * @return client
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenoms
     *
     * @param string $prenoms
     * @return client
     */
    public function setPrenoms($prenoms)
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    /**
     * Get prenoms
     *
     * @return string 
     */
    public function getPrenoms()
    {
        return $this->prenoms;
    }

   
    /**
     * Set datnaissance
     *
     * @param \DateTime $datnaissance
     * @return client
     */
    public function setDatnaissance($datnaissance)
    {
        $this->datnaissance = $datnaissance;

        return $this;
    }

    /**
     * Get datnaissance
     *
     * @return \DateTime 
     */
    public function getDatnaissance()
    {
        return $this->datnaissance;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return client
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     * @return client
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string 
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return client
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set profession
     *
     * @param string $profession
     * @return client
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return string 
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return client
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set caissier
     *
     * @param string $caissier
     * @return client
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
     * Set cashpoint
     *
     * @param string $cashpoint
     * @return client
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->operation = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add operation
     *
     * @param \fascli\MainBundle\Entity\operations $operation
     * @return client
     */
    public function addOperation(\fascli\MainBundle\Entity\operations $operation)
    {
        $this->operation[] = $operation;

        return $this;
    }

    /**
     * Remove operation
     *
     * @param \fascli\MainBundle\Entity\operations $operation
     */
    public function removeOperation(\fascli\MainBundle\Entity\operations $operation)
    {
        $this->operation->removeElement($operation);
    }

    /**
     * Get operation
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * toString
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function __toString()
    {
       
        return "$this->nom  $this->prenoms";
    }

    /**
     * Set nomprenoms
     *
     * @param string $nomprenoms
     * @return client
     */
    public function setNomprenoms($nomprenoms)
    {
        $this->nomprenoms = $nomprenoms;

        return $this;
    }

    /**
     * Get nomprenoms
     *
     * @return string 
     */
    public function getNomprenoms()
    {
        return $this->nomprenoms;
    }

    /**
     * Add operationsbdc
     *
     * @param \fascli\BdcBundle\Entity\operationsbdc $operationsbdc
     * @return client
     */
    public function addOperationsbdc(\fascli\BdcBundle\Entity\operationsbdc $operationsbdc)
    {
        $this->operationsbdc[] = $operationsbdc;

        return $this;
    }

    /**
     * Remove operationsbdc
     *
     * @param \fascli\BdcBundle\Entity\operationsbdc $operationsbdc
     */
    public function removeOperationsbdc(\fascli\BdcBundle\Entity\operationsbdc $operationsbdc)
    {
        $this->operationsbdc->removeElement($operationsbdc);
    }

    /**
     * Get operationsbdc
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOperationsbdc()
    {
        return $this->operationsbdc;
    }
}
