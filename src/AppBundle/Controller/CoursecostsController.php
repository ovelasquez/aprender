<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Coursecosts;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Coursecost controller.
 *
 * @Route("coursecosts")
 */
class CoursecostsController extends Controller
{
    /**
     * Lists all coursecost entities.
     *
     * @Route("/", name="coursecosts_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $coursecosts = $em->getRepository('AppBundle:Coursecosts')->findAll();

        return $this->render('coursecosts/index.html.twig', array(
            'coursecosts' => $coursecosts,
        ));
    }

    /**
     * Creates a new coursecost entity.
     *
     * @Route("/new", name="coursecosts_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $coursecost = new Coursecosts();
        $form = $this->createForm('AppBundle\Form\CoursecostsType', $coursecost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($coursecost);
            $em->flush($coursecost);

            return $this->redirectToRoute('coursecosts_show', array('id' => $coursecost->getId()));
        }

        return $this->render('coursecosts/new.html.twig', array(
            'coursecost' => $coursecost,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a coursecost entity.
     *
     * @Route("/{id}", name="coursecosts_show")
     * @Method("GET")
     */
    public function showAction(Coursecosts $coursecost)
    {
        $deleteForm = $this->createDeleteForm($coursecost);

        return $this->render('coursecosts/show.html.twig', array(
            'coursecost' => $coursecost,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing coursecost entity.
     *
     * @Route("/{id}/edit", name="coursecosts_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Coursecosts $coursecost)
    {
        $deleteForm = $this->createDeleteForm($coursecost);
        $editForm = $this->createForm('AppBundle\Form\CoursecostsType', $coursecost);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coursecosts_edit', array('id' => $coursecost->getId()));
        }

        return $this->render('coursecosts/edit.html.twig', array(
            'coursecost' => $coursecost,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a coursecost entity.
     *
     * @Route("/{id}", name="coursecosts_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Coursecosts $coursecost)
    {
        $form = $this->createDeleteForm($coursecost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($coursecost);
            $em->flush($coursecost);
        }

        return $this->redirectToRoute('coursecosts_index');
    }

    /**
     * Creates a form to delete a coursecost entity.
     *
     * @param Coursecosts $coursecost The coursecost entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Coursecosts $coursecost)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('coursecosts_delete', array('id' => $coursecost->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
