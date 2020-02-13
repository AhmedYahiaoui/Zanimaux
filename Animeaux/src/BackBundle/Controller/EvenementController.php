<?php

namespace BackBundle\Controller;

use FrontBundle\Entity\Evenement;
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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evenements = $em->getRepository('FrontBundle:Evenement')->findAll();

        return $this->render('BackBundle:evenement:indexAdmin.html.twig', array(
            'evenements' => $evenements,
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

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $evenement->uploadProfilePicture();


            $em->persist($evenement);
            $em->flush();

            return $this->redirectToRoute('evenement_Admin_show', array('ref' => $evenement->getRef()));
        }

        return $this->render('BackBundle:evenement:new.html.twig', array(
            'evenement' => $evenement,
            'form' => $form->createView(),

        ));
    }

    /**
     * Finds and displays a evenement entity.
     *
     */
    public function showAction(Evenement $evenement)
    {


        return $this->render('BackBundle:evenement:indexAdmin.html.twig', array(
            'evenement' => $evenement,

        ));
    }

    /**
     * Displays a form to edit an existing evenement entity.
     *
     */
    public function editAction(Request $request, Evenement $evenement)
    {

        $editForm = $this->createForm('FrontBundle\Form\EvenementType2', $evenement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $evenement->uploadProfilePicture();


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_Admin_index');
        }

        return $this->render('BackBundle:evenement:edit.html.twig', array(
            'evenement' => $evenement,
            'edit_Admin_form' => $editForm->createView(),

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


            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();


        return $this->redirectToRoute('evenement_Admin_index');
    }


    private function createDeleteForm(Evenement $evenement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evenement_Admin_delete', array('ref' => $evenement->getRef())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function delete1Action ($id)
    {
        $em=$this->getDoctrine()->getManager();
        $modele=$em->getRepository('FrontBundle:Evenement')->find($id);
        $em->remove($modele);
        $em->flush();
        return $this->redirectToRoute('evenement_Admin_index');

    }


}
