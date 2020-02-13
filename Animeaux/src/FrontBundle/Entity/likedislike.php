<?php

namespace FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * likedislike
 *
 * @ORM\Table(name="likedislike")
 * @ORM\Entity(repositoryClass="FrontBundle\Repository\likedislikeRepository")
 */
class likedislike
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
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;


    /**
     * @var integer
     *
     * @ORM\Column(name="id_Article", type="integer")
     */
    private $id_Article;


    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer")
     */
    private $id_user;




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getIdArticle()
    {
        return $this->id_Article;
    }

    /**
     * @param int $id_Article
     */
    public function setIdArticle($id_Article)
    {
        $this->id_Article = $id_Article;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param int $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }



}

