<?php

namespace FrontBundle\Controller;

use FrontBundle\Entity\Evenement;
use FrontBundle\Entity\Feed;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Evenement controller.
 *
 */
class EvenementController extends Controller
{
    /**
     * Lists all evenement entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $evenements = $em->getRepository('FrontBundle:Evenement')->Top5();



        $paginator  = $this->get('knp_paginator');

            $pagination =$paginator ->paginate($evenements,$request->query->getInt('page',1),5);


        return $this->render('FrontBundle:evenement:index.html.twig', array(

            'R'=>$pagination
        ));
    }

    /**
     * Creates a new evenement entity.
     *
     */
    public function newAction(Request $request)
    {
        $evenement = new Evenement();
        $form = $this->createForm('FrontBundle\Form\EvenementType', $evenement);

        $form->handleRequest($request);
            $evenement->setNbrParticipant(0);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $evenement->uploadProfilePicture();


            $em->persist($evenement);
            $em->flush();

            return $this->redirectToRoute('evenement_show', array('ref' => $evenement->getRef()));
        }

        return $this->render('FrontBundle:evenement:new.html.twig', array(
            'evenement' => $evenement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a evenement entity.
     *
     */

    public function showAction(Evenement $evenement,Request $request)
    {
        $d=new \DateTime('now');

        //Affiche feedback
        $em = $this->getDoctrine()->getManager();



        //Participer
        $nbr = $evenement->getNbrParticipant();
            if ($request->getMethod()=='POST'){
                if ($request->get('part')&&$evenement->getDateFin()>$d){

                    $nbr=$nbr+1;
                    $evenement->setNbrParticipant($nbr);
                    $em=$this->getDoctrine()->getManager();
                    $em->persist($evenement);
                    $em->flush();

                }
            }

         // Ajout FeedBack

        $feed= new Feed();

        $id_client= 1 ;
        $evenement_id=$evenement->getRef();
        $feed_input =$request->request->get('test');
        if($request->getMethod()=='POST' && $feed_input!=""&&$evenement->getDateFin()<$d)
        {
            $feed->setIdUser($id_client);
            $feed->setIdEvent($evenement_id);
            $feed->setDescription($feed_input);
            $feed->setDateFeed(new \DateTime('now'));



}

        $em=$this->getDoctrine()->getManager();
        $em->persist($feed);
        $em->flush();
        $deleteForm = $this->createDeleteForm($evenement);
        $feedEvent= $em->getRepository('FrontBundle:Feed')->findFeedbyEvent($evenement->getRef());

        return $this->render('FrontBundle:evenement:show.html.twig', array(
            'evenement' => $evenement,
            'delete_form' => $deleteForm->createView(),
            'feedEvent'=>$feedEvent,
            'success'=>'check the Date befor'
        ));
    }

    /**
     * Displays a form to edit an existing evenement entity.
     *
     */
    public function editAction(Request $request, Evenement $evenement)
    {
        $deleteForm = $this->createDeleteForm($evenement);
        $editForm = $this->createForm('FrontBundle\Form\EvenementType', $evenement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $evenement->uploadProfilePicture();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_edit', array('ref' => $evenement->getRef()));
        }

        return $this->render('FrontBundle:evenement:edit.html.twig', array(
            'evenement' => $evenement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a evenement entity.
     *
     */
    public function deleteAction(Request $request, Evenement $evenement)
    {
        $form = $this->createDeleteForm($evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
        }

        return $this->redirectToRoute('evenement_index');
    }

    /**
     * Creates a form to delete a evenement entity.
     *
     * @param Evenement $evenement The evenement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Evenement $evenement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evenement_delete', array('ref' => $evenement->getRef())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
