<?php

namespace fascli\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * nouvelles
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="fascli\MainBundle\Repository\nouvellesRepository")
 */
class nouvelles
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
     * @ORM\Column(name="datenr", type="datetime")
     */
    private $datenr;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="enregistreur", type="string", length=100)
     */
    private $enregistreur;


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
     * Set datenr
     *
     * @param \DateTime $datenr
     * @return nouvelles
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

    /**
     * Set titre
     *
     * @param string $titre
     * @return nouvelles
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return nouvelles
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set enregistreur
     *
     * @param string $enregistreur
     * @return nouvelles
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
}
