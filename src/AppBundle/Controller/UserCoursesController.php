<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserCourses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Usercourse controller.
 *
 * @Route("usercourses")
 */
class UserCoursesController extends Controller
{
    /**
     * Lists all userCourse entities.
     *
     * @Route("/", name="usercourses_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userCourses = $em->getRepository('AppBundle:UserCourses')->findAll();

        return $this->render('usercourses/index.html.twig', array(
            'userCourses' => $userCourses,
        ));
    }

    /**
     * Creates a new userCourse entity.
     *
     * @Route("/new", name="usercourses_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userCourse = new Usercourse();
        $form = $this->createForm('AppBundle\Form\UserCoursesType', $userCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userCourse);
            $em->flush($userCourse);

            return $this->redirectToRoute('usercourses_show', array('id' => $userCourse->getId()));
        }

        return $this->render('usercourses/new.html.twig', array(
            'userCourse' => $userCourse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userCourse entity.
     *
     * @Route("/{id}", name="usercourses_show")
     * @Method("GET")
     */
    public function showAction(UserCourses $userCourse)
    {
        $deleteForm = $this->createDeleteForm($userCourse);

        return $this->render('usercourses/show.html.twig', array(
            'userCourse' => $userCourse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userCourse entity.
     *
     * @Route("/{id}/edit", name="usercourses_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserCourses $userCourse)
    {
        //$deleteForm = $this->createDeleteForm($userCourse);
        $editForm = $this->createForm('AppBundle\Form\UserCoursesType', $userCourse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usercourses_edit', array('id' => $userCourse->getId()));
        }

        return $this->render('usercourses/edit.html.twig', array(
            'userCourse' => $userCourse,
            'edit_form' => $editForm->createView(),
      
        ));
    }

    /**
     * Deletes a userCourse entity.
     *
     * @Route("/{id}", name="usercourses_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserCourses $userCourse)
    {
        $form = $this->createDeleteForm($userCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userCourse);
            $em->flush($userCourse);
        }

        return $this->redirectToRoute('usercourses_index');
    }

    /**
     * Creates a form to delete a userCourse entity.
     *
     * @param UserCourses $userCourse The userCourse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserCourses $userCourse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usercourses_delete', array('id' => $userCourse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
