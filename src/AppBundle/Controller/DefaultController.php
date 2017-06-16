<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Courses;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        //$courses = $em->getRepository('AppBundle:Courses')->findBy(array("status" => '1'), array("id" => "desc"));

        $par = array();
        $par[] = array("status", ">=", 1);
        //$par[] = array("enddate", ">", date("Y-m-d"));
        $courses = $em->getRepository('AppBundle:Courses')->findAllBy('', $par);

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            // replace this example code with whatever you need
            return $this->render('default/index.html.twig', [
                        'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
            ]);
        }

        //
        $coursesToApprove = $em->getRepository('AppBundle:UserCourses')->findMyCoursesToApprove($this->getUser()->getId());
        $userCourses = $em->getRepository('AppBundle:UserCourses')->findAllMyCourses($this->getUser()->getId());

        // replace this example code with whatever you need
        return $this->render('default/estudiante.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'courses' => $courses,
                    'userCourses' => $userCourses,
                    'countToApprove' => count($coursesToApprove),
        ]);
    }

    /**
     * @Route("/home", name="frontpage")
     * @Method({"GET", "POST"})
     */
    public function frontpageAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $par = $this->getCriteria($request);
        $par[] = array("status", ">=", 1);

        $courses = $em->getRepository('AppBundle:Courses')->findAllBy($request->request->get('q'), $par);

        $coursesCategories = $em->getRepository('AppBundle:Coursecategories')->findAll();
        $courseCosts = $em->getRepository('AppBundle:Coursecosts')->findAll();

        return $this->render('default/frontpage.html.twig', array(
                    'courses' => $courses,
                    'coursesCategories' => $coursesCategories, 'courseCosts' => $courseCosts,
                    'selCategory' => $request->request->get('category'), 'selCost' => $request->request->get('cost'), 'selCountry' => $request->request->get('country'), 'selState' => $request->request->get('province'), 'q' => $request->request->get('q'),
        ));
    }

    /**
     * @Route("/list", name="courses_list_home")
     * @Method({"GET", "POST"})
     */
    public function courseslistAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $par = $this->getCriteria($request);
        $par[] = array("status", ">=", 1);

        $courses = $em->getRepository('AppBundle:Courses')->findAllBy($request->request->get('q'), $par);

        $coursesCategories = $em->getRepository('AppBundle:Coursecategories')->findAll();
        $courseCosts = $em->getRepository('AppBundle:Coursecosts')->findAll();

        return $this->render('default/courseslist.html.twig', array(
                    'courses' => $courses,
                    'coursesCategories' => $coursesCategories, 'courseCosts' => $courseCosts,
                    'selCategory' => $request->request->get('category'), 'selCost' => $request->request->get('cost'), 'selCountry' => $request->request->get('country'), 'selState' => $request->request->get('province'), 'q' => $request->request->get('q'),
        ));
    }

    /**
     * @Route("/instructor", name="instructor")
     */
    public function instructorAction(Request $request) {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $courses = $em->getRepository('AppBundle:Courses')->findBy(array('user' => $user->getId()), array('id' => 'desc'), 10);

        $studentToApprove = $em->getRepository('AppBundle:UserCourses')->findMyStudentToApprove($this->getUser()->getId());

        return $this->render('default/instructor.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'courses' => $courses,
                    'countToApprove' => count($studentToApprove),
        ]);
    }

    /**
     * Finds and displays a course entity.
     *
     * @Route("/student/{id}", name="student_show")
     * @Method("GET")
     */
    public function showstudentAction($id) {

        $em = $this->getDoctrine()->getManager();

        $student = $em->getRepository('AppBundle:User')->find($id);

        return $this->render('default/showstudent.html.twig', array(
                    'student' => $student,
        ));
    }

    /**
     * Finds and displays a course entity.
     *
     * @Route("/course/{id}", name="default_course_show")
     * @Method("GET")
     * 
     */
    public function showCourseAction(Courses $course,Request $request) {
        $em = $this->getDoctrine()->getManager();
        $registerForm = $this->createRegisterForm($course);

        $infoReview = $this->isEvaluated($course);

        $coursesCategories = $em->getRepository('AppBundle:Coursecategories')->findAll();
        $courseCosts = $em->getRepository('AppBundle:Coursecosts')->findAll();

        return $this->render('default/show.html.twig', array(
                    'course' => $course, 'coursesCategories' => $coursesCategories, 'courseCosts' => $courseCosts,
                    'register_form' => ($this->isRegistered($course) === false && $course->isActiveToRegister()) ? $registerForm->createView() : null,
                    'registered' => ($this->isRegistered($course) === true ) ? 1 : 0,
                    'isevaluated' => ($infoReview !== false ) ? $infoReview : null,
                    'selCategory' => $request->request->get('category'), 'selCost' => $request->request->get('cost'), 'selCountry' => $request->request->get('country'), 'selState' => $request->request->get('province'), 'q' => $request->request->get('q'),
        ));
    }

    /**
     * Creates a register user course entity.
     *
     * @Route("/course/register/{id}", name="default_course_register")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function registerAction(Request $request, Courses $course) {
        $form = $this->createRegisterForm($course);
        $form->handleRequest($request);
        $user = $this->getUser();

        //dump($user->getCourses()->toArray());die();
        if ($form->isSubmitted() && $form->isValid() && $this->isRegistered($course) === false) {
//            $usercourse = new UserCourses();
//            $usercourse->setUser($user);
//            $usercourse->setCourse($course);
//            $usercourse->setStatus(-1);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($usercourse);
//            $em->flush($usercourse);

            return $this->redirectToRoute('payments_new', array('course_id' => $course->getId()));
        }

        return $this->redirectToRoute('courses_show', array('id' => $course->getId()));
    }

    /**
     * Creates a form to register a user.
     *
     * @param Courses $course The course entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createRegisterForm(Courses $course) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('courses_register', array('id' => $course->getId())))
                        ->getForm()
        ;
    }

    /**
     * Verify a user.
     *
     * @param Courses $course The course entity
     *
     * @return boolean
     */
    private function isRegistered(Courses $course) {
        $user = $this->getUser();
        $courses = ($user !== null) ? $user->getCourses()->toArray() : array();
        if (count($courses) > 0) {
            for ($i = 0; $i < count($courses); $i++):
                if ($courses[$i]->getId() == $course->getId()): return true;
                endif;
            endfor;
        }
        return false;
    }

    /**
     * Verify review by user.
     *
     * @param Courses $course The course entity
     *
     * @return \AppBundle\Reviews
     */
    private function isEvaluated(Courses $course) {
        $user = $this->getUser();
        //dump($user);die();
        $courses = ($user !== null) ? $user->getCourses()->toArray() : array();
        if (count($courses) > 0) {
            for ($i = 0; $i < count($courses); $i++):
                if ($courses[$i]->getId() == $course->getId()):
                    $review = $this->getDoctrine()->getManager()->getRepository('AppBundle:Reviews')->findOneBy(array('evaluator' => $user->getId(), 'evaluated' => $course->getId(), 'type' => 'curso'));
                    //dump($review);die();
                    if ($review !== null):
                        return $review;
                    endif;
                endif;
            endfor;
        }
        return false;
    }

    /**
     * Finds and displays a course entity.
     *
     * @Route("/help", name="help")
     * @Method("GET")
     */
    public function helpAction() {



        return $this->render('default/help.html.twig', array(
        ));
    }

    /**
     * Load criterios
     *
     * @param Request
     *
     * @return array
     */
    private function getCriteria($request) {
        $par = array();
        if (($request->request->get('category')) !== null && ($request->request->get('category')) !== ''): $par[] = array("category", "=", $request->request->get('category'));
        endif;
        if (($request->request->get('country')) !== null && ($request->request->get('country')) !== ''): $par[] = array("country", "=", $request->request->get('country'));
        endif;
        if (($request->request->get('province')) !== null && ($request->request->get('province')) !== ''): $par[] = array("province", "=", $request->request->get('province'));
        endif;
        if (($request->request->get('cost')) !== null && ($request->request->get('cost')) !== ''): $par[] = array("cost", "=", $request->request->get('cost'));
        endif;

        return $par;
    }

}
