<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Coursecategories;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Coursecategory controller.
 *
 * @Route("coursecategories")
 */
class CoursecategoriesController extends Controller
{
    /**
     * Lists all coursecategory entities.
     *
     * @Route("/", name="coursecategories_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $coursecategories = $em->getRepository('AppBundle:Coursecategories')->findAll();

        return $this->render('coursecategories/index.html.twig', array(
            'coursecategories' => $coursecategories,
        ));
    }

    /**
     * Creates a new coursecategory entity.
     *
     * @Route("/new", name="coursecategories_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $coursecategory = new Coursecategories();
        $form = $this->createForm('AppBundle\Form\CoursecategoriesType', $coursecategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($coursecategory);
            $em->flush($coursecategory);

            return $this->redirectToRoute('coursecategories_show', array('id' => $coursecategory->getId()));
        }

        return $this->render('coursecategories/new.html.twig', array(
            'coursecategory' => $coursecategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a coursecategory entity.
     *
     * @Route("/{id}", name="coursecategories_show")
     * @Method("GET")
     */
    public function showAction(Coursecategories $coursecategory)
    {
        $deleteForm = $this->createDeleteForm($coursecategory);

        return $this->render('coursecategories/show.html.twig', array(
            'coursecategory' => $coursecategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing coursecategory entity.
     *
     * @Route("/{id}/edit", name="coursecategories_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Coursecategories $coursecategory)
    {
        $deleteForm = $this->createDeleteForm($coursecategory);
        $editForm = $this->createForm('AppBundle\Form\CoursecategoriesType', $coursecategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coursecategories_edit', array('id' => $coursecategory->getId()));
        }

        return $this->render('coursecategories/edit.html.twig', array(
            'coursecategory' => $coursecategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a coursecategory entity.
     *
     * @Route("/{id}", name="coursecategories_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Coursecategories $coursecategory)
    {
        $form = $this->createDeleteForm($coursecategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($coursecategory);
            $em->flush($coursecategory);
        }

        return $this->redirectToRoute('coursecategories_index');
    }

    /**
     * Creates a form to delete a coursecategory entity.
     *
     * @param Coursecategories $coursecategory The coursecategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Coursecategories $coursecategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('coursecategories_delete', array('id' => $coursecategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
