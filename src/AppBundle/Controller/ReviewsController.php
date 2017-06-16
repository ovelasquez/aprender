<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reviews;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Review controller.
 *
 * @Route("reviews")
 */
class ReviewsController extends Controller {

    /**
     * Lists all review entities.
     *
     * @Route("/", name="reviews_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $reviews = $em->getRepository('AppBundle:Reviews')->findAll();

        return $this->render('reviews/index.html.twig', array(
                    'reviews' => $reviews,
        ));
    }

    /**
     * Creates a new review entity student in course.
     *
     * @Route("/new/{student}/{course}", name="reviews_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $student, $course) {
        $em = $this->getDoctrine()->getManager();
        $ucR = $em->getRepository('AppBundle:Reviews')->findOneBy(array("evaluator" => $course, "evaluated" => $student));
        if ($ucR !== null):
            return $this->redirectToRoute('reviews_show', array('id' => $ucR->getId()));
        endif;
        $userStudent = $em->getRepository('AppBundle:User')->find($student);
        $courseTaken = $em->getRepository('AppBundle:Courses')->find($course);
        $userCourse = $em->getRepository('AppBundle:UserCourses')->findOneBy(array("user" => $userStudent, "course" => $courseTaken));
        if ($userCourse !== null):
            $review = new Reviews();
            $form = $this->createForm('AppBundle\Form\ReviewsType', $review);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($review);
                $em->flush($review);
                return $this->redirectToRoute('reviews_show', array('id' => $review->getId()));
            }
            return $this->render('reviews/new.html.twig', array(
                        'review' => $review, 'form' => $form->createView(), 'userStudent' => $userStudent, 'course' => $course,
            ));
        else:
            return $this->redirectToRoute('courses_show_users_ini');
        endif;
    }

    /**
     * Creates a new review entity  course by student.
     *
     * @Route("/course/new/{course}", name="reviews_course_new")
     * @Method({"GET", "POST"})
     */
    public function newcourseAction(Request $request, $course) {
        $em = $this->getDoctrine()->getManager();
        $userStudent = $this->getUser();
        $ucR = $em->getRepository('AppBundle:Reviews')->findOneBy(array("evaluator" => $userStudent->getId(), "evaluated" => $course));
        if ($ucR !== null):
            return $this->redirectToRoute('reviews_show_course', array('id' => $ucR->getId()));
        endif;
        $courseTaken = $em->getRepository('AppBundle:Courses')->find($course);
        $userCourse = $em->getRepository('AppBundle:UserCourses')->findOneBy(array("user" => $userStudent, "course" => $courseTaken));
        if ($userCourse !== null):
            $review = new Reviews();
            $form = $this->createForm('AppBundle\Form\ReviewsType', $review);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($review);
                $em->flush($review);
                return $this->redirectToRoute('reviews_show_course', array('id' => $review->getId()));
            }
            return $this->render('reviews/newcourse.html.twig', array(
                        'review' => $review, 'form' => $form->createView(), 'userStudent' => $userStudent, 'course' => $courseTaken,
            ));
        else:
            return $this->redirectToRoute('courses_indexcompleted');
        endif;
    }

    /**
     * Finds and displays a review entity.
     *
     * @Route("/course/{id}", name="reviews_show_course")
     * @Method("GET")
     */
    public function showcourseAction(Reviews $review) {
        $deleteForm = $this->createDeleteForm($review);
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('AppBundle:Courses')->find($review->getEvaluated());

        return $this->render('reviews/showcourse.html.twig', array(
                    'review' => $review,
                    'delete_form' => $deleteForm->createView(),
                    'course' => $course,
        ));
    }
    
    /**
     * Finds and displays a review entity.
     *
     * @Route("/{id}", name="reviews_show")
     * @Method("GET")
     */
    public function showAction(Reviews $review) {
        $deleteForm = $this->createDeleteForm($review);
        $em = $this->getDoctrine()->getManager();
        $userStudent = $em->getRepository('AppBundle:User')->find($review->getEvaluated());

        return $this->render('reviews/show.html.twig', array(
                    'review' => $review,
                    'delete_form' => $deleteForm->createView(),
                    'userStudent' => $userStudent,
        ));
    }

    /**
     * Displays a form to edit an existing review entity.
     *
     * @Route("/{id}/edit", name="reviews_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reviews $review) {
        $deleteForm = $this->createDeleteForm($review);
        $editForm = $this->createForm('AppBundle\Form\ReviewsType', $review);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reviews_edit', array('id' => $review->getId()));
        }

        return $this->render('reviews/edit.html.twig', array(
                    'review' => $review,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a review entity.
     *
     * @Route("/{id}", name="reviews_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reviews $review) {
        $form = $this->createDeleteForm($review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($review);
            $em->flush($review);
        }

        return $this->redirectToRoute('reviews_index');
    }

    /**
     * Creates a form to delete a review entity.
     *
     * @param Reviews $review The review entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reviews $review) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('reviews_delete', array('id' => $review->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
