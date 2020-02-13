<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\Column(name="id_client", type="integer", nullable=true)
     */
    private $id_client;

    /**
     * @var int
     *
     * @ORM\Column(name="id_produits", type="integer", nullable=true)
     */
    private $id_produits ;

    /**
     * @var int
     *
     * @ORM\Column(name="qte", type="integer", nullable=true)
     */
    private $qte ;

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
    public function getIdClient()
    {
        return $this->id_client;
    }

    /**
     * @param int $id_client
     */
    public function setIdClient($id_client)
    {
        $this->id_client = $id_client;
    }

    /**
     * @return int
     */
    public function getIdProduits()
    {
        return $this->id_produits;
    }

    /**
     * @param int $id_produits
     */
    public function setIdProduits($id_produits)
    {
        $this->id_produits = $id_produits;
    }

    /**
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * @param int $qte
     */
    public function setQte($qte)
    {
        $this->qte = $qte;
    }



}