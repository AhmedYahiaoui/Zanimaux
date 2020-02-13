<?php

namespace BackBundle\Controller;

use FrontBundle\Entity\Feed;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Feed controller.
 *
 * @Route("feed")
 */
class FeedController extends Controller
{
    /**
     * Lists all feed entities.
     *
     * @Route("/", name="feed_Admin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $feeds = $em->getRepository('FrontBundle:Feed')->findAll();

        return $this->render('BackBundle:feed:index.html.twig', array(
            'feeds' => $feeds,
        ));
    }

    /**
     * Creates a new feed entity.
     *
     * @Route("/new", name="feed_Admin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $feed = new Feed();
        $form = $this->createForm('FrontBundle\Form\FeedType', $feed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($feed);
            $em->flush();

            return $this->redirectToRoute('feed_Admin_show', array('id' => $feed->getId()));
        }

        return $this->render('BackBundle:feed:new.html.twig', array(
            'feed' => $feed,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a feed entity.
     *
     * @Route("/{id}", name="feed_Admin_show")
     * @Method("GET")
     */
    public function showAction(Feed $feed)
    {
        $deleteForm = $this->createDeleteForm($feed);

        return $this->render('BackBundle:feed:show.html.twig', array(
            'feed' => $feed,
            'delete_Admin_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing feed entity.
     *
     * @Route("/{id}/edit", name="feed_Admin_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Feed $feed)
    {
        $deleteForm = $this->createDeleteForm($feed);
        $editForm = $this->createForm('FrontBundle\Form\FeedType', $feed);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('feed_Admin_edit', array('id' => $feed->getId()));
        }

        return $this->render('BackBundle:feed:edit.html.twig', array(
            'feed' => $feed,
            'edit_Admin_form' => $editForm->createView(),
            'delete_Admin_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a feed entity.
     *
     * @Route("/{id}", name="feed_Admin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Feed $feed)
    {
        $form = $this->createDeleteForm($feed);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $em->remove($feed);
        $em->flush();


        return $this->redirectToRoute('feed_Admin_index');
    }

    /**
     * Creates a form to delete a feed entity.
     *
     * @param Feed $feed The feed entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Feed $feed)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('feed_Admin_delete', array('id' => $feed->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

}
