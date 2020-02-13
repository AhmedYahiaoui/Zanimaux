<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use FrontBundle\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;


class ProduitController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('FrontBundle:Produit')->findAll();

        return $this->render('BackBundle:produit:indexAdmin.html.twig', array(
            'produits' => $produits,
        ));
    }

    /**
     * Creates a new produit entity.
     *
     */
    public function newAction(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm('FrontBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $produit->uploadProfilePicture();

            $produit->setRating(1);


            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_Admin_show', array('ref' => $produit->getRef()));
        }

        return $this->render('BackBundle:produit:new.html.twig', array(
            'produit' => $produit,
            'f' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     */
    public function showAction(Produit $produit,Request $request)
    {

        // reservation
        $id_Admin_produit=$produit->getRef();
        $qte=$produit->getQuantite();
        $id_Admin_client= 1 ;

        $qte_Admin_input =$request->request->get('test');

        if($qte_Admin_input<=$qte)
        {
            $rest=$qte-$qte_Admin_input;
            $produit->setQuantite($rest);
                $reservation=new Reservation();
                $reservation->setIdClient($id_Admin_client);
                $reservation->setIdProduits($id_Admin_produit);
                $reservation->setQte($qte_Admin_input);


            $em=$this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();
        }


        $form = $this->createForm('FrontBundle\Form\RatingsType',$produit);
        $form->handleRequest($request);

        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('BackBundle:produit:show.html.twig', array(
            'produit' => $produit,
            'delete_Admin_form' => $deleteForm->createView(),
            'f'=> $form->createView(),
            'success'=>'test'
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     */
    public function editAction(Request $request, Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('FrontBundle\Form\ProduitType2', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $produit->uploadProfilePicture();
            $this->getDoctrine()->getManager()->flush();


           // $produit->setNomImage()

            return $this->redirectToRoute('produit_Admin_index', array('ref' => $produit->getRef()));
        }

        return $this->render('BackBundle:produit:edit.html.twig', array(
            'produit' => $produit,
            'f' => $editForm->createView(),
            'delete_Admin_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     */
    public function deleteAction(Request $request, Produit $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_Admin_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_Admin_delete', array('ref' => $produit->getRef())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
