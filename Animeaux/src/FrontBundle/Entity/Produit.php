<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * produit
 *
 * @ORM\Table(name="produits")
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="ref", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ref;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=255, nullable=true)
     */
    private $marque;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_boutique", type="string", length=255, nullable=true)
     */
    private $adresseBoutique;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_boutique", type="string", length=255, nullable=true)
     */
    private $nomBoutique;

    /**
     * @var int
     *
     * @ORM\Column(name="num_tele", type="integer", nullable=true)
     */
    private $numTele;


    /**
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=true)
     */
    private $etat;


    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    private $nomImage;

    /**
     * @Assert\File(maxSize="500k")
     */
    private $file;

    /**
     * @ORM\Column(type="integer",length=11)
     */
    private $rating;









    /**
     * Get nomImage
     * @return string
     */
    public function getNomImage()
    {
        return $this->nomImage;
    }

    /**
     * Set nomImage
     *
     * @param string $nomImage
     *
     * @return Produit
     */
    public function setNomImage($nomImage)
    {
        $this->nomImage == $nomImage;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }


    public function getWebPath()
    {
        return null===$this->nomImage ? null : $this->getUploadDir().'/'.$this->nomImage;
    }

    protected function getUploadRootDir(){
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir(){
        return 'images';
    }

    public function uploadProfilePicture(){
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
        $this->nomImage=$this->file->getClientOriginalName();
        $this->file=null;
    }




    /**
     * Set type
     *
     * @param string $type
     *
     * @return Produit
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Produit
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
     * Set marque
     *
     * @param string $marque
     *
     * @return Produit
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Produit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Produit
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Produit
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set adresseBoutique
     *
     * @param string $adresseBoutique
     *
     * @return Produit
     */
    public function setAdresseBoutique($adresseBoutique)
    {
        $this->adresseBoutique = $adresseBoutique;

        return $this;
    }

    /**
     * Get adresseBoutique
     *
     * @return string
     */
    public function getAdresseBoutique()
    {
        return $this->adresseBoutique;
    }

    /**
     * Set nomBoutique
     *
     * @param string $nomBoutique
     *
     * @return Produit
     */
    public function setNomBoutique($nomBoutique)
    {
        $this->nomBoutique = $nomBoutique;

        return $this;
    }

    /**
     * Get nomBoutique
     *
     * @return string
     */
    public function getNomBoutique()
    {
        return $this->nomBoutique;
    }

    /**
     * Set numTele
     *
     * @param integer $numTele
     *
     * @return Produit
     */
    public function setNumTele($numTele)
    {
        $this->numTele = $numTele;

        return $this;
    }

    /**
     * Get numTele
     *
     * @return int
     */
    public function getNumTele()
    {
        return $this->numTele;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Produit
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @return int
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }







}

