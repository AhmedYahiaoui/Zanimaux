<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nbrvues
 *
 * @ORM\Table(name="nbrvues")
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\NbrvuesRepository")
 */
class Nbrvues
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idArticle", type="integer")
     */
    private $idArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseip", type="string", length=255)
     */
    private $adresseip;

    /**
     * @var \Date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * @param int $idArticle
     */
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;
    }

    /**
     * @return string
     */
    public function getAdresseip()
    {
        return $this->adresseip;
    }

    /**
     * @param string $adresseip
     */
    public function setAdresseip($adresseip)
    {
        $this->adresseip = $adresseip;
    }

    /**
     * @return \Date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \Date $date
     */
    public function setDate()
    {
        $this->date = new \DateTime();
    }





}