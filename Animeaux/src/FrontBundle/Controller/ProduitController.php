<?php

namespace FrontBundle\Controller;

use AppBundle\Entity\User;
use FrontBundle\Entity\Produit;
use FrontBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * produit controller.
 *
 */
class ProduitController extends Controller
{
    /**
     * Lists all produit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('FrontBundle:Produit')->findAll();
        $p_Cosmetique = $em->getRepository('FrontBundle:Produit')->findProduitParCosmetique();
        $p_Accesoire= $em->getRepository('FrontBundle:Produit')->findProduitParAccesoire();
        $p_Alimentaire= $em->getRepository('FrontBundle:Produit')->findProduitParAlimentaire();

        return $this->render('FrontBundle:produit:index.html.twig', array(
            'produits' => $produits,
            'p_cos' => $p_Cosmetique,
            'p_acc' => $p_Accesoire,
            'p_ali' => $p_Alimentaire,

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

            return $this->redirectToRoute('produit_show', array('ref' => $produit->getRef()));
        }

        return $this->render('FrontBundle:produit:new.html.twig', array(
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
        $id_produit=$produit->getRef();
        $qte=$produit->getQuantite();
        $id_client= 1 ;

        $qte_input =$request->request->get('test');

        if($qte_input<=$qte)
        {
            $rest=$qte-$qte_input;
            $produit->setQuantite($rest);
                $reservation=new Reservation();
                $reservation->setIdClient($id_client);
                $reservation->setIdProduits($id_produit);
                $reservation->setQte($qte_input);


            $em=$this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();
        }


        $form = $this->createForm('FrontBundle\Form\RatingsType',$produit);
        $form->handleRequest($request);

        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('FrontBundle:produit:show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
            'f'=> $form->createView(),
            'success'=>'check the quantity befor'
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

            return $this->redirectToRoute('produit_index', array('ref' => $produit->getRef()));
        }

        return $this->render('FrontBundle:produit:edit.html.twig', array(
            'produit' => $produit,
            'f' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

        return $this->redirectToRoute('produit_index');
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
            ->setAction($this->generateUrl('produit_delete', array('ref' => $produit->getRef())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
