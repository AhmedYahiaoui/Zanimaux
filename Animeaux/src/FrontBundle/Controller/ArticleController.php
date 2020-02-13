<?php

namespace FrontBundle\Controller;

use FrontBundle\Entity\Article;
use FrontBundle\Entity\Commentaire;
use FrontBundle\Entity\Nbrvues;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;




/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     */
    public function indexAction()
    {






        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('FrontBundle:Article')->findAll();

        return $this->render('FrontBundle:article:index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Creates a new article entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser()->getId();


        $article = new Article();
        $form = $this->createForm('FrontBundle\Form\ArticleType', $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $article->uploadProfilePicture();
            $article->setIdUser($user);
            $article->setNbVue(0);
            $article->setDateCreation(new \DateTime('now'));


            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }

        return $this->render('FrontBundle:article:new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     */
    public function showAction(Article $article,Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //nbt vue
        $ip=$this->container->get('request_stack')->getCurrentRequest()->getClientIp();

        $thisTime=new \DateTime();

        $checkIp= $em->getRepository('FrontBundle:Nbrvues')->findOneBy(array('adresseip'=>$ip,'date'=>$thisTime,'idArticle'=>$article->getId())) ;
       $nbrVues= $em->getRepository('FrontBundle:Nbrvues')->findBy(array('idArticle'=>$article->getId()));


        if(!$checkIp){

            $vue=new Nbrvues();

            $vue->setIdArticle($article->getId());
            $vue->setAdresseip($ip);
            $vue->setDate();
            $em->persist($vue);
            $em->flush();
           // $nbrVues= $em->getRepository('FrontBundle:Nbrvues')->findidArticleVue($article->getId());


            //$article->setNbVue($nbrVues);

            $em->persist($article);
            $em->flush();

        }


//Bundle PDF


/*

        $this->get('knp_snappy.pdf')->generateFromHtml(
            $this->renderView(
                'FrontBundle:Article:index.html.twig',
                array(
                    'some'  => $article
                )
            ),
            'D:\Apps\wamp64\www\SymfonyProject\Animeaux\web\images\file.pdf'
        );

*/



        //Affiche Commentaire
        $em = $this->getDoctrine()->getManager();


        // Ajout Commentaire
        $id_client= $this->getUser()->getId();
        $Article_id=$article->getId();
        $Commentaire_input =$request->request->get('test2');
        if($request->getMethod()=='POST' && $Commentaire_input!="")
        {   $commentaire= new Commentaire();
            $commentaire->setIdUser($id_client);
            $commentaire->setIdArticle($Article_id);
            $commentaire->setDescription($Commentaire_input);
            $commentaire->setDateCommentaire(new \DateTime('now'));


            $em=$this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

        }
        $CommentaireArticle= $em->getRepository('FrontBundle:Commentaire')->findFeedbyEvent($article->getId());

        $deleteForm = $this->createDeleteForm($article);

        return $this->render('FrontBundle:article:show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
            'CommentaireArticle'=>$CommentaireArticle,
            'nbrVue'=>$nbrVues
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('FrontBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $article->uploadProfilePicture();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');

        }

        return $this->render('FrontBundle:article:edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a article entity.
     *
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    public function likeAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getId();
        $a3=$request->request->get('val');

        $abath=0;



        if($request->request->get('val')) {
            $ev1 = $em->getRepository('FrontBundle:likedislike')->findLikeDislike($user, $a3);
            if ($ev1) {
                $ld = $em->getRepository('FrontBundle:likedislike')->find($ev1);
                $abath = $ld->getType();
            }
        }


        $em->flush();
        $serializer = new Serializer(array(new ObjectNormalizer()));
        $data = $serializer->normalize($abath);
        return new JsonResponse($data);

    }

    public function VeterinaireAction()
    {
        $query = $this->getDoctrine()->getEntityManager()
            ->createQuery(
                'SELECT u FROM UserBundle:User u WHERE u.roles LIKE :role'
            )->setParameter('role', '%"ROLE_VETERINAIRE"%');

        $articles = $query->getResult();



/*
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('FrontBundle:Article')->findUserParRole();
*/
        return $this->render('FrontBundle:article:veterinaire.html.twig', array(
            'articles' => $articles,
        ));
    }



}
