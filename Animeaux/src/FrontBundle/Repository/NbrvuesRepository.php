<?php

namespace FrontBundle\Repository;

/**
 * NbrvuesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NbrvuesRepository extends \Doctrine\ORM\EntityRepository
{
    public function findidArticleVue($id)
    {
        $query = $this->getEntityManager()->createQuery("select count(c.id) from FrontBundle:Nbrvues c WHERE c.idArticle LIKE :id ")
        ->setParameter('id','%'.$id.'%');

        return $query->getResult();


    }
}
