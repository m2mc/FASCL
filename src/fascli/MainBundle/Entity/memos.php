<?php

namespace fascli\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * memos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="fascli\MainBundle\Repository\memosRepository")
 */
class memos
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
     * @ORM\Column(name="de", type="string", length=100)
     */
    private $de;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=100)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;


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
     * @return memos
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
     * Set de
     *
     * @param string $de
     * @return memos
     */
    public function setDe($de)
    {
        $this->de = $de;

        return $this;
    }

    /**
     * Get de
     *
     * @return string 
     */
    public function getDe()
    {
        return $this->de;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return memos
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
     * @return memos
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
}
