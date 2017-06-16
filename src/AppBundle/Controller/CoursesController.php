<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Courses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\UserCourses;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Course controller.
 *
 * @Route("courses")
 */
class CoursesController extends Controller {

    /**
     * Lists all course entities.
     *
     * @Route("/", name="courses_index")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $par = $this->getCriteria($request);
        $user = $this->getUser();
        $par[] = array("user", "=", $user->getId());

        $courses = $em->getRepository('AppBundle:Courses')->findAllBy($request->request->get('q'), $par);
        $coursesCategories = $em->getRepository('AppBundle:Coursecategories')->findAll();
        $courseCosts = $em->getRepository('AppBundle:Coursecosts')->findAll();
        //$courses = $em->getRepository('AppBundle:Courses')->findAll();
//        $courses = $em->getRepository('AppBundle:Courses')->findBy(array('user' => $user->getId()), array('startdate' => "DESC"));

        return $this->render('courses/index.html.twig', array(
                    'courses' => $courses,
                    'coursesCategories' => $coursesCategories, 'courseCosts' => $courseCosts,
                    'selCategory' => $request->request->get('category'), 'selCost' => $request->request->get('cost'), 'selCountry' => $request->request->get('country'), 'selState' => $request->request->get('province'), 'q' => $request->request->get('q'),
        ));
    }

    /**
     * Lists all course entities.
     *
     * @Route("/list", name="courses_index_list")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_SUPER_ADMIN')") 
     */
    public function listAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $par = $this->getCriteria($request);
        $courses = $em->getRepository('AppBundle:Courses')->findAllBy($request->request->get('q'), $par, ' c.status, c.id ASC');

        $coursesCategories = $em->getRepository('AppBundle:Coursecategories')->findAll();
        $courseCosts = $em->getRepository('AppBundle:Coursecosts')->findAll();

        return $this->render('courses/list.html.twig', array(
                    'courses' => $courses,
                    'coursesCategories' => $coursesCategories, 'courseCosts' => $courseCosts,
                    'selCategory' => $request->request->get('category'), 'selCost' => $request->request->get('cost'), 'selCountry' => $request->request->get('country'), 'selState' => $request->request->get('province'), 'q' => $request->request->get('q'),
        ));
    }

    /**
     * Lists all course entities.
     *
     * @Route("/all", name="courses_indexall")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function indexallAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $par = $this->getCriteria($request);
        $par[] = array("status", "=", 1);
        $par[] = array("enddate", ">", date("Y-m-d"));
        $courses = $em->getRepository('AppBundle:Courses')->findAllBy($request->request->get('q'), $par);

        $coursesCategories = $em->getRepository('AppBundle:Coursecategories')->findAll();
        $courseCosts = $em->getRepository('AppBundle:Coursecosts')->findAll();

        return $this->render('courses/indexall.html.twig', array(
                    'courses' => $courses,
                    'coursesCategories' => $coursesCategories, 'courseCosts' => $courseCosts,
                    'selCategory' => $request->request->get('category'), 'selCost' => $request->request->get('cost'), 'selCountry' => $request->request->get('country'), 'selState' => $request->request->get('province'), 'q' => $request->request->get('q'),
        ));
    }

    /**
     * Lists all course entities.
     *
     * @Route("/completed", name="courses_indexcompleted")
     * @Method("GET")
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function indexcompletedAction() {
        $em = $this->getDoctrine()->getManager();

        $courses = $em->getRepository('AppBundle:UserCourses')->findAllOrderedByUserCompleted($this->getUser()->getId());

        return $this->render('courses/indexcompleted.html.twig', array(
                    'courses' => $courses,
        ));
    }

    /**
     * Lists all my courses entities.
     *
     * @Route("/mycourses", name="courses_indexmycourses")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function indexmycoursesAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $par = $this->getCriteriaV($request);
        
       // dump($par, $request->request->get('q') ); die();
      
        $courses = $em->getRepository('AppBundle:UserCourses')->findAllMyCourses($this->getUser()->getId(), $par, $request->request->get('q'));

        $coursesEv = $em->getRepository('AppBundle:UserCourses')->findMyCoursesToApprove($this->getUser()->getId());

        $arrCourEva = array();
        foreach ($coursesEv as $cou):
            $arrCourEva[] = $cou["id"];
        endforeach;

        foreach ($courses as $cou):
            if (in_array($cou->getId(), $arrCourEva)): $cou->setByEvaluation(1);
            else: $cou->setByEvaluation(0);
            endif;
        endforeach;

        $coursesCategories = $em->getRepository('AppBundle:Coursecategories')->findAll();
        $courseCosts = $em->getRepository('AppBundle:Coursecosts')->findAll();

        $coursesN = array();
        if (count($courses) == 0):
            $par = array();
            $par[] = array("status", "=", 1);
            $par[] = array("enddate", ">", date("Y-m-d"));
            $coursesN = $em->getRepository('AppBundle:Courses')->findAllBy('', $par);
        endif;

        

        return $this->render('courses/indexmycourses.html.twig', array(
                    'courses' => $courses,
                    'coursesN' => $coursesN,
                    'coursesCategories' => $coursesCategories, 'courseCosts' => $courseCosts,
                    'selCategory' => $request->request->get('category'), 'selCost' => $request->request->get('cost'), 'selCountry' => $request->request->get('country'), 'selState' => $request->request->get('province'), 'q' => $request->request->get('q'),
        ));
    }

    /**
     * Permite a un Estudiante calificar los Cursos
     *
     * @Route("/completed/qualify", name="courses_indexcompleted_qualify")
     * @Method("GET")
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function indexcompletedqualifyAction() {
        $em = $this->getDoctrine()->getManager();

        $courses = $em->getRepository('AppBundle:UserCourses')->findMyCoursesToApprove($this->getUser()->getId());

        return $this->render('courses/indexcompletedqualify.html.twig', array(
                    'courses' => $courses,
        ));
    }

    /**
     * Lists all course entities to qualify.
     *
     * @Route("/completed/qualify/students", name="courses_indexcompletedst_qualify")
     * @Method("GET")
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function indexcompletedqualifyStAction() {
        $em = $this->getDoctrine()->getManager();

        $students = $em->getRepository('AppBundle:UserCourses')->findMyStudentToApprove($this->getUser()->getId());

        //dump($students); die();
        return $this->render('courses/indexcompletedstqualify.html.twig', array(
                    'students' => $students,
        ));
    }

    /**
     * Lists all course user.
     *
     * @Route("/registered", name="courses_index_user")
     * @Method("GET")
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function registeredAction() {

        $user = $this->getUser();
        $courses = $user->getCourses()->toArray();

        return $this->render('courses/registered.html.twig', array(
                    'courses' => $courses,
        ));
    }

    /**
     * Finds and displays a course entity.
     *
     * @Route("/students/{id}", name="courses_show_users_ini")
     * @Method("GET")
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function usersiniAction($id = null) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $courses = $em->getRepository('AppBundle:Courses')->findBy(array('user' => $user->getId()));
        $course = null;

        if ($id === null && count($courses) > 0) {
            $course = $courses[0];
            $users = ($courses[0]->getUsers() !== null) ? $courses[0]->getUsers()->toArray() : array();
        } elseif ($id !== null) {
            $course = $em->getRepository('AppBundle:Courses')->find($id);
            $users = ($course->getUsers() !== null) ? $course->getUsers()->toArray() : array();
        } else {
            $users = array();
        }

        $usersInf = $usersA = array();

        foreach ($users as $value) {
            $usersA[] = $value->getId();
        }

        if (is_array($usersA)):
            $usersInf = $em->getRepository('AppBundle:UserCourses')->findAllOrderedByUsers(implode(",", $usersA), $course);
        endif;

        return $this->render('courses/users.html.twig', array(
                    'courses' => $courses,
                    'users' => $usersInf,
                    'id' => $id,
        ));


        //return $this->redirectToRoute('courses_show_users', array('id' => $course->getId()));
    }

    /**
     * Creates a new course entity.
     *
     * @Route("/new", name="courses_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function newAction(Request $request) {
        $course = new Courses();
        $form = $this->createForm('AppBundle\Form\CoursesType', $course, array('locations' => $this->getParameter("locations"),));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $time = (strtotime($course->getStartdate()));
//            $inicio = date('Y-m-d', $time);
//            $time = (strtotime($course->getEnddate()));
//            $fin = date('Y-m-d', $time);
//            $course->setStartdate(new \DateTime($inicio));
//            $course->setEnddate(new \DateTime($fin));

            $course->setStartdate(\DateTime::createFromFormat('d/m/Y', $course->getStartdate()));

            $course->setEnddate(\DateTime::createFromFormat('d/m/Y', $course->getEnddate()));

            $course->setStatus(0); //Status por aprobar

            $user = $this->getUser();

            $course->setUser($user);

            $em = $this->getDoctrine()->getManager();

            $em->persist($course);

            $em->flush($course);

            //Enviar Email al Instructor y al Estudiante
            $asunto = "Lest Know: Curso Postulación";

            $this->sendEmail($asunto, $course, 'marianamff@gmail.com');

            $this->addFlash('success', 'Cursos creado satisfactoriamente');

            return $this->redirectToRoute('courses_show', array('id' => $course->getId()));
        }

        return $this->render('courses/new.html.twig', array(
                    'course' => $course,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a course entity.
     *
     * @Route("/{id}", name="courses_show")
     * @Method("GET")
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function showAction(Courses $course) {

        $deleteForm = $this->createDeleteForm($course);
        $registerForm = $this->createRegisterForm($course);
        $etiqueta = '';
        $clase = '';
        $calificar= FALSE;


        if ($this->getUser()->getRoles()[0] === 'ROLE_ADMIN' || $course->getUser()->getId() == $this->getUser()->getId()) { // El Usuario es Administrador 0 Instructor
            switch ($course->getStatus()) {
                case (0): $etiqueta = "Por Aprobación";
                    $clase = "text-white bg-warning rounded";

                    break;
                case (1): $etiqueta = "Curso Aprobado";
                    $clase = "text-white bg-primary rounded";

                    break;
                case (-1): $etiqueta = "Rechazado";
                    $clase = "text-white bg-danger rounded";

                    break;
            }
        } else {

            // El Usuario es un Estudiante

            if (1 == $course->getStatus()) { // Curso Aprobado
                $infoReview = FALSE;
                $status = 0;

                if ($this->isRegistered($course) === TRUE) { // Esta Registrado en el Curso
                    $em = $this->getDoctrine()->getManager();

                    // Verificamos el estatus: aprobado (1), rechazado (-1) o por aprobacion (0)
                    $buscar = $em->getRepository('AppBundle:UserCourses')->findBy(array('course' => $course->getId(), 'user' => $this->getUser()->getId()));

                    switch ($buscar[0]->getStatus()) {

                        case (0):
                            $etiqueta = "Estudiante Por Aprobación";
                            $clase = "text-white bg-warning rounded";
                            break;

                        case (1):
                            //Estudiante Suscrito 

                            if ($this->isRegistered($course)) {                                                                                           
 
                                if (($course->isCompleted())) {
                                    
                                    $etiqueta = "  Suscrito - Curso Finalizado ";
                                    $clase = "text-white bg-success rounded";
                                    $calificar= TRUE;
                                    
                                } else {                                   
                                    
                                     if ($course->isActiveToRegister()) {
                                         
                                        $etiqueta = "  Suscrito  ";
                                        $clase = "text-white bg-primary rounded";
                                        
                                    } else {
                                        
                                        $etiqueta = "  Suscrito - Curso en Ejecución ";
                                        $clase = "text-white bg-primary rounded";
                                        
                                    }
                                }
                            }

                            // $infoReview = $this->isEvaluated($course); //Mi opinion sobre el curso (Calificacion)                            
                            break;

                        case (-1): $etiqueta = "Estudiante Rechazado";
                            $clase = "text-white bg-danger rounded";

                            break;
                    }
                }
            }
        }
      
        return $this->render('courses/show.html.twig', array(
                    'course' => $course,
                    'delete_form' => $deleteForm->createView(),                    
                    'register_form' => ($this->isRegistered($course) === false ) ? $registerForm->createView() : null,                   
                    'isevaluated' => ($this->isEvaluated($course) !== false ) ? $this->isEvaluated($course) : null,                   
                    'etiqueta' => $etiqueta,
                    'clase' => $clase,
                    'calificar' => $calificar,
        ));
    }

    /**
     * Finds and displays a course entity.
     *
     * @Route("/{id}/view", name="courses_view")
     * @Method("GET")
     * @Security("has_role('ROLE_SUPER_ADMIN')") 
     */
    public function viewAction(Courses $course) {
        //$deleteForm = $this->createDeleteForm($course);
        $editStatusForm = $this->createReviewForm($course);

        $infoReview = $this->isEvaluated($course);

        return $this->render('courses/view.html.twig', array(
                    'course' => $course,
                    //'delete_form' => $deleteForm->createView(),
                    'edit_status_form' => $editStatusForm->createView(),
                    //'register_form' => ($this->isRegistered($course) === false && $course->isActiveToRegister()) ? $registerForm->createView() : null,
                    'registered' => ($this->isRegistered($course) === true ) ? 1 : 0,
                    'isevaluated' => ($infoReview !== false ) ? $infoReview : null,
        ));
    }

    /**
     * Finds and displays a course entity.
     *
     * @Route("/view/{id}", name="courses_show_ins")
     * @Method("GET")
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function showinsAction(Courses $course) {

        $deleteForm = $this->createDeleteForm($course);
        $registerForm = $this->createRegisterForm($course);

        $infoReview = $this->isEvaluated($course);

        $users = ($course->getUsers() !== null) ? $course->getUsers()->toArray() : array();

        $usersInf = $usersA = array();
        foreach ($users as $value) {
            $usersA[] = $value->getId();
        }
        $em = $this->getDoctrine()->getManager();
        if (is_array($usersA)):
            $usersInf = $em->getRepository('AppBundle:UserCourses')->findAllOrderedByUsers(implode(",", $usersA), $course);
        endif;

        return $this->render('courses/showins.html.twig', array(
                    'course' => $course,
                    'delete_form' => $deleteForm->createView(),
                    'register_form' => ($this->isRegistered($course) === false && $course->isActiveToRegister()) ? $registerForm->createView() : null,
                    'registered' => ($this->isRegistered($course) === true ) ? 1 : 0,
                    'isevaluated' => ($infoReview !== false ) ? $infoReview : null,
                    'usersInf' => $usersInf,
        ));
    }

    /**
     * Displays a form to edit an existing course entity.
     *
     * @Route("/{id}/edit", name="courses_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USUARIO') or has_role('ROLE_SUPER_ADMIN')") 
     */
    public function editAction(Request $request, Courses $course) {

        //Verificamos si el Curso es del Estudiante que està tratando de editar
        if ($this->getUser()->getRoles()[0] === 'ROLE_USUARIO' && $course->getUser()->getId() != $this->getUser()->getId()) {

            return $this->redirectToRoute('homepage', array());
        }
        $course->setStartdate(date_format($course->getStartdate(), "d/m/Y"));
        $course->setEnddate(date_format($course->getEnddate(), "d/m/Y"));
        $fileOld = $course->getPhoto();
        $deleteForm = $this->createDeleteForm($course);
        $editForm = $this->createForm('AppBundle\Form\CoursesType', $course, array(
            'locations' => $this->getParameter("locations"),
        ));
        $editForm->handleRequest($request);

        if ($course->getPhoto() === null && $fileOld !== null) {
            $course->setPhoto($fileOld);
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $course->setStartdate(\DateTime::createFromFormat('d/m/Y', $course->getStartdate()));
            $course->setEnddate(\DateTime::createFromFormat('d/m/Y', $course->getEnddate()));

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Cursos editado satisfactoriamente');

            switch ($this->getUser()->getRoles()[0]) {
                case('ROLE_USUARIO'): return $this->redirectToRoute('courses_show', array('id' => $course->getId()));
                    break;
                case('ROLE_SUPER_ADMIN'): return $this->redirectToRoute('courses_view', array('id' => $course->getId()));
                    break;
            }
        }

        return $this->render('courses/edit.html.twig', array(
                    'course' => $course,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    public function sendEmail($asunto, $course, $email) {
        $message = \Swift_Message::newInstance()
                ->setSubject($asunto)
                ->setFrom('marianamff@gmail.com')
                ->setTo([$course->getUser()->getEmail(), $email])
                ->setBody(
                $this->renderView(
                        'emails/registrationNewCourse.html.twig', array('course' => $course, 'photoOourse' => "uploads/fotos/" . $course->getPhoto())
                ), 'text/html'
                )
        ;
        $this->get('mailer')->send($message);
    }

    /**
     * Deletes a course entity.
     *
     * @Route("/{id}", name="courses_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')") 
     */
    public function deleteAction(Request $request, Courses $course) {
        $form = $this->createDeleteForm($course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($course);
            $em->flush($course);
        }

        return $this->redirectToRoute('courses_new');
    }

    /**
     * Creates a form to review a course entity.
     *
     * @param Courses $course The course entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createReviewForm(Courses $course) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('courses_review', array('id' => $course->getId())))
                        ->getForm()
        ;
    }

    /**
     * Deletes a course entity.
     *
     * @Route("/{id}/review", name="courses_review")     
     * @Security("has_role('ROLE_ADMIN')") 
     */
    public function reviewAction(Request $request, Courses $course) {
        $form = $this->createReviewForm($course);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($request->request->get("app") !== null && $course->getStatus() === 0):
                $course->setStatus(1);
                //Enviar Email Notificando la Aprobacion o Rechazo del Curso            
                $this->sendEmail("Lest Know: Postulación de Curso Aprobado", $course, "marianamff@gmail.com");

            elseif ($request->request->get("disapp") !== null && $course->getStatus() === 0):
                $course->setStatus(-1);
                //Enviar Email Notificando la Aprobacion o Rechazo del Curso            
                $this->sendEmail("Lest Know: Postulación de Curso Rechazada", $course, "marianamff@gmail.com");

            elseif ($request->request->get("desact") !== null):
                $course->setStatus(0);
            endif;

            $em->persist($course);
            $em->flush($course);
        }

        return $this->redirectToRoute('courses_view', array('id' => $course->getId()));
    }

    /**
     * Creates a form to delete a course entity.
     *
     * @param Courses $course The course entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Courses $course) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('courses_delete', array('id' => $course->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Creates a register user course entity.
     *
     * @Route("/register/{id}", name="courses_register")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USUARIO')") 
     */
    public function registerAction(Request $request, Courses $course) {
        $form = $this->createRegisterForm($course);
        $form->handleRequest($request);
        $user = $this->getUser();

        //dump($user->getCourses()->toArray());die();
        if ($form->isSubmitted() && $form->isValid() && $this->isRegistered($course) === false) {

            if ($course->getCost()->getPrice() == 0) {

                $em = $this->getDoctrine()->getManager();

                /* $usercourse = new UserCourses();
                  $usercourse->setUser($user);
                  $usercourse->setCourse($course);
                  $usercourse->setStatus(-1);


                  $em->persist($usercourse);
                  $em->flush($usercourse);
                 */

                $usercourse = new UserCourses();
                $usercourse->setUser($this->getUser());
                $usercourse->setCourse($course);
                $usercourse->setStatus(0);

                $em->persist($usercourse);
                $em->flush($usercourse);

                //Enviar Email al Estudiante e Instructor notificando 
                $this->sendEmail("Lest Know: Postulación al Curso", $course, $this->getUser()->getEmail());

                $this->addFlash('success', 'Registramos satisfactoriamente su Postulación al Curso');

                return $this->redirectToRoute('courses_show', array('id' => $course->getId()));
            } else {

                return $this->redirectToRoute('payments_new', array('course_id' => $course->getId()));
            }
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

        $courses = $user->getCourses()->toArray();

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
        $courses = $user->getCourses()->toArray();
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

    /**
     * Load criterios
     *
     * @param Request
     *
     * @return array
     */
    private function getCriteriaV($request) {
        $par = array();
        if (($request->request->get('category')) !== null && ($request->request->get('category')) !== ''): $par[] = array("category_id", "=", $request->request->get('category'));
        endif;
        if (($request->request->get('country')) !== null && ($request->request->get('country')) !== ''): $par[] = array("country", "=", $request->request->get('country'));
        endif;
        if (($request->request->get('province')) !== null && ($request->request->get('province')) !== ''): $par[] = array("province", "=", $request->request->get('province'));
        endif;
        if (($request->request->get('cost')) !== null && ($request->request->get('cost')) !== ''): $par[] = array("cost_id", "=", $request->request->get('cost'));
        endif;

        return $par;
    }

}
