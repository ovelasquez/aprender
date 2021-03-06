<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Payments;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\UserCourses;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Payment controller.
 *
 * @Route("payments")
 */
class PaymentsController extends Controller {

    /**
     * Lists all payment entities.
     *
     * @Route("/", name="payments_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $payments = $em->getRepository('AppBundle:Payments')->findBy(array("user" => $this->getUser()));
        return $this->render('payments/index.html.twig', array(
                    'payments' => $payments,
        ));
    }

    /**
     * Lists all payment entities.
     *
     * @Route("/admin", name="payments_admin")
     * @Method({"GET", "POST"})
     */
    public function adminAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $consulta = NULL;
        $rangos = '';
        $salida = '';

        if ($request->isMethod('POST')) {
            $var = $request->request->get('form');
            $rango = explode("-", $var['daterange']);
            $rango = str_replace("/", "-", $rango);

            // $contador = 'SELECT currency, COUNT(c.id) FROM lkw_payments as c where c.status=:status and c.pdatetime BETWEEN (:desde) AND (:hasta) GROUP BY currency';
            $datos = "SELECT p.id, c.id as course_id, c.title, u.id as user_id, u.name,u.last_name, p.status, p.pdatetime, p.currency, p.amount 
                        FROM lkw_payments as p
                        LEFT JOIN lkw_courses as c on c.id = p.course_id
                        LEFT JOIN lkw_user as u on u.id = p.user_id
                        WHERE p.status=:status and p.pdatetime BETWEEN (:desde) AND (:hasta)";
            $parametros = array('status' => 'approved', 'desde' => trim($rango[0]), 'hasta' => trim($rango[1]));
            //  $consulta = $this->ejecutarQuery($contador, $parametros);
            $consultaDatos = $this->ejecutarQuery($datos, $parametros);
            //dump($consultaDatos);     die();
            /*
              foreach ($consulta as &$valor) {
              $salida = $salida . " {label: '" . ucwords($valor['currency']) . "', value:" . $valor['COUNT(c.id)'] . "},";
              }

             */
        } else {
             $datos = "SELECT p.id, c.id as course_id, c.title, u.id as user_id, u.name,u.last_name, p.status, p.pdatetime, p.currency, p.amount 
                        FROM lkw_payments as p
                        LEFT JOIN lkw_courses as c on c.id = p.course_id
                        LEFT JOIN lkw_user as u on u.id = p.user_id
                        WHERE p.status=:status ";
            $parametros = array('status' => 'approved');           
            $consultaDatos = $this->ejecutarQuery($datos, $parametros);
        }


        if (!$consulta) {
            $hoy = new \DateTime('now');
            $rangos = $hoy->format('Y/m/d H:i:s');
            $rangos = $rangos . ' - ' . $rangos;
        } else {
            $rangos = $request->request->get('daterange');
        }

        //Creamos el formulario de Consulta
        $form = $this->crearFormulario("payments_admin", $rangos);
        $form->handleRequest($request);

        return $this->render('payments/admin.html.twig', array(
                    'payments' => $consultaDatos,
                    'consultas' => '',
                    'rango' => $rangos,
                    'form' => $form->createView(),
        ));
    }

    private function crearFormulario($url, $rangos) {
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl($url))
                ->add('daterange', TextType::class, array(
                    'label' => 'Rango de Fecha',
                    'required' => true,
                    'attr' => array('placeholder' => $rangos),
                ))
                ->getForm();
        return $form;
    }

    private function ejecutarQuery($sql, $parametros) {
        $conn = $this->getDoctrine()->getManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->fetchAll();
    }

    /**
     * Lists all payment entities.
     *
     * @Route("/statement", name="payments_index_statement")
     * @Method("GET")
     */
    public function statementAction() {
        $em = $this->getDoctrine()->getManager();
        $payments = $em->getRepository('AppBundle:Payments')->findByCourseUser($this->getUser());        
        $paymentsbyMonth = $em->getRepository('AppBundle:Payments')->findByCourseUserMonth($this->getUser());
        
        $total = 0;
        //dump($payments); die();
        foreach ($payments as $payment) {
            $total = $total + (int) $payment["tota"];
        }
        return $this->render('payments/statement.html.twig', array(
                    'payments' => $payments,
                    'total' => $total,
                    'paymentsbyMonth' => $paymentsbyMonth,
        ));
    }

    /**
     * Creates a new payment entity.
     *
     * @Route("/new/{course_id}", name="payments_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $course_id) {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('AppBundle:Courses')->find($course_id);

        $payment = new Payments();
        $payment->setCourse($course);
        $payment->setUser($this->getUser());

//        $form = $this->createForm('AppBundle\Form\PaymentsType', $payment);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $payment->setCourse($course);
//            $payment->setUser($this->getUser());
//            $payment->setStatus(100);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($payment);
//            $em->flush($payment);
//
//            return $this->redirectToRoute('payments_show', array('id' => $payment->getId()));
//        }

        return $this->render('payments/new.html.twig', array(
                    'payment' => $payment,
//                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new payment entity.
     *
     * @Route("/registerpay/{course_id}", name="payments_registerpay")
     * @Method({"GET", "POST"})
     */
    public function registerpayAction(Request $request, $course_id) {
        $ch = curl_init();
        $clientId = "ARvOCmpyGYFcaMCM3-FeCLi7hia0G51JLCoeGzBJeybvtlUgpmef-5B6PRBZFHH8BJvqiYdsiV2WjjE8";
        $secret = "EDYfinFWaXp7jR8ZxtkmwVzUHHVX0ta2D5byLZgCaFZDoG8wRXeUUllUBcJt40w_zQE5uZXwCj0N71vz";

        curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        $result = curl_exec($ch);

        if (empty($result))
            return $this->redirectToRoute('payments_new', array('course_id' => $course_id));
        else {
            $json = json_decode($result);
        }

        $paymentID = $request->get("paymentId");
        $tokenID = $json->access_token;

        $curl = curl_init('https://api.sandbox.paypal.com/v1/payments/payment/' . $paymentID);
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $tokenID,
            'Accept: application/json',
            'Content-Type: application/json'
        ));
        $response = curl_exec($curl);
        $result = json_decode($response);

        curl_close($ch);

        if (empty($result) || $result->state !== "approved"):
            return $this->redirectToRoute('payments_new', array('course_id' => $course_id));
        endif;

        //Enviar Email al Estudiante e Instructor notificando 
        $this->sendEmail("Lest Know: Postulación al Curso", $course, $this->getUser()->getEmail());

        //$this->addFlash('success', 'Registramos satisfactoriamente su Postulación al Curso');        

        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('AppBundle:Courses')->find($course_id);

        $payment = new Payments();
        $payment->setCourse($course);
        $payment->setUser($this->getUser());
        $payment->setStatus((string) $result->state);
        $payment->setAmount((int) (isset($result->transactions[0]) ? $result->transactions[0]->amount->total : 0));
        $payment->setCurrency("USD");
        $payment->setResult($response);

        $em->persist($payment);
        $em->flush($payment);

        $usercourse = new UserCourses();
        $usercourse->setUser($this->getUser());
        $usercourse->setCourse($course);
        $usercourse->setStatus(0);

        $em->persist($usercourse);
        $em->flush($usercourse);

        return $this->redirectToRoute('payments_show', array('id' => $payment->getId()));
    }

    public function sendEmail($asunto, $course, $email) {
        $message = \Swift_Message::newInstance()
                ->setSubject($asunto)
                ->setFrom($this->getParameter('notify_eamil'))
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
     * Finds and displays a payment entity.
     *
     * @Route("/{id}", name="payments_show")
     * @Method("GET")
     */
    public function showAction(Payments $payment) {
        //$deleteForm = $this->createDeleteForm($payment);

        $invoce = json_decode($payment->getResult());
        //dump($invoce);

        return $this->render('payments/show.html.twig', array(
                    'payment' => $payment,
                    'invoce' => $invoce,
                        //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing payment entity.
     *
     * @Route("/{id}/edit", name="payments_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Payments $payment) {
        $deleteForm = $this->createDeleteForm($payment);
        $editForm = $this->createForm('AppBundle\Form\PaymentsType', $payment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payments_edit', array('id' => $payment->getId()));
        }

        return $this->render('payments/edit.html.twig', array(
                    'payment' => $payment,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a payment entity.
     *
     * @Route("/{id}", name="payments_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Payments $payment) {
        $form = $this->createDeleteForm($payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($payment);
            $em->flush($payment);
        }

        return $this->redirectToRoute('payments_index');
    }

    /**
     * Creates a form to delete a payment entity.
     *
     * @param Payments $payment The payment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Payments $payment) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('payments_delete', array('id' => $payment->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
