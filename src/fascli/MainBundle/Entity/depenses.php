<?php

namespace fascli\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * depenses
 *
 * @ORM\Table(name="depenses")
 * @ORM\Entity(repositoryClass="fascli\MainBundle\Repository\depensesRepository")
 */
class depenses
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
     * @ORM\Column(name="datdepense", type="date")
     */
    private $datdepense;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="text")
     */
    private $libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="montant", type="integer")
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="caisse", type="string", length=10)
     */
    private $caisse;

    /**
     * @var string
     *
     * @ORM\Column(name="autorisation", type="string", length=100)
     */
    private $autorisation;

    /**
     * @var string
     *
     * @ORM\Column(name="cashpoint", type="string", length=10)
     */
    private $cashpoint;

    /**
     * @var string
     *
     * @ORM\Column(name="rubrique", type="string", length=100)
     */
    private $rubrique;

    /**
     * @var string
     *
     * @ORM\Column(name="enregistreur", type="string", length=100)
     */
    private $enregistreur;

    /**
     * @var integer
     *
     * @ORM\Column(name="nfacture", type="integer")
     */
    private $nfacture;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=20)
     */
    private $statut;


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
     * Set datdepense
     *
     * @param \DateTime $datdepense
     * @return depenses
     */
    public function setDatdepense($datdepense)
    {
        $this->datdepense = $datdepense;

        return $this;
    }

    /**
     * Get datdepense
     *
     * @return \DateTime 
     */
    public function getDatdepense()
    {
        return $this->datdepense;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return depenses
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set montant
     *
     * @param integer $montant
     * @return depenses
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
     * Set autorisation
     *
     * @param string $autorisation
     * @return depenses
     */
    public function setAutorisation($autorisation)
    {
        $this->autorisation = $autorisation;

        return $this;
    }

    /**
     * Get autorisation
     *
     * @return string 
     */
    public function getAutorisation()
    {
        return $this->autorisation;
    }

    /**
     * Set cashpoint
     *
     * @param string $cashpoint
     * @return depenses
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
     * Set rubrique
     *
     * @param string $rubrique
     * @return depenses
     */
    public function setRubrique($rubrique)
    {
        $this->rubrique = $rubrique;

        return $this;
    }

    /**
     * Get rubrique
     *
     * @return string 
     */
    public function getRubrique()
    {
        return $this->rubrique;
    }

    /**
     * Set enregistreur
     *
     * @param string $enregistreur
     * @return depenses
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
     * Set nfacture
     *
     * @param integer $nfacture
     * @return depenses
     */
    public function setNfacture($nfacture)
    {
        $this->nfacture = $nfacture;

        return $this;
    }

    /**
     * Get nfacture
     *
     * @return integer 
     */
    public function getNfacture()
    {
        return $this->nfacture;
    }

    /**
     * Set statut
     *
     * @param string $statut
     * @return depenses
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set caisse
     *
     * @param string $caisse
     * @return depenses
     */
    public function setCaisse($caisse)
    {
        $this->caisse = $caisse;

        return $this;
    }

    /**
     * Get caisse
     *
     * @return string 
     */
    public function getCaisse()
    {
        return $this->caisse;
    }
}
