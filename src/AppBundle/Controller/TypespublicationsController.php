<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typespublications;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typespublication controller.
 *
 * @Route("typespublications")
 */
class TypespublicationsController extends Controller
{
    /**
     * Lists all typespublication entities.
     *
     * @Route("/", name="typespublications_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typespublications = $em->getRepository('AppBundle:Typespublications')->findAll();

        return $this->render('typespublications/index.html.twig', array(
            'typespublications' => $typespublications,
        ));
    }

    /**
     * Creates a new typespublication entity.
     *
     * @Route("/new", name="typespublications_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typespublication = new Typespublications();
        $form = $this->createForm('AppBundle\Form\TypespublicationsType', $typespublication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typespublication);
            $em->flush($typespublication);

            return $this->redirectToRoute('typespublications_show', array('id' => $typespublication->getId()));
        }

        return $this->render('typespublications/new.html.twig', array(
            'typespublication' => $typespublication,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typespublication entity.
     *
     * @Route("/{id}", name="typespublications_show")
     * @Method("GET")
     */
    public function showAction(Typespublications $typespublication)
    {
        $deleteForm = $this->createDeleteForm($typespublication);

        return $this->render('typespublications/show.html.twig', array(
            'typespublication' => $typespublication,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typespublication entity.
     *
     * @Route("/{id}/edit", name="typespublications_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Typespublications $typespublication)
    {
        $deleteForm = $this->createDeleteForm($typespublication);
        $editForm = $this->createForm('AppBundle\Form\TypespublicationsType', $typespublication);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typespublications_edit', array('id' => $typespublication->getId()));
        }

        return $this->render('typespublications/edit.html.twig', array(
            'typespublication' => $typespublication,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typespublication entity.
     *
     * @Route("/{id}", name="typespublications_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Typespublications $typespublication)
    {
        $form = $this->createDeleteForm($typespublication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typespublication);
            $em->flush($typespublication);
        }

        return $this->redirectToRoute('typespublications_index');
    }

    /**
     * Creates a form to delete a typespublication entity.
     *
     * @param Typespublications $typespublication The typespublication entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typespublications $typespublication)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typespublications_delete', array('id' => $typespublication->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
