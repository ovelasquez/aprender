<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ajax controller.
 * @author Oscar Velasquez
 * @Route("ajax")
 * 
 */
class AjaxController extends Controller {

    /**
     * Carga los costos de los cursos en la moneda seleccionada
     *
     * @Route("/cost", name="ajax_cost")
     * @Method({"POST"})
     */
    public function costAction(Request $request) {
        $id =$request->request->get('id');

        $em = $this->getDoctrine()->getManager();
        
        $grupos = $em->getRepository('AppBundle:Coursecosts')->findByCurrency($id);
        
        $valores = '<option value="" selected="selected">Seleccione</option> ';
        
        foreach ($grupos as $valor) {
            $valores = $valores . ' <option value=' . $valor->getId() . '>' . $valor->getName() . ' | ' . $valor->getCurrency()->getName().' '. $valor->getPrice() . '</option> ';
        }
        return $this->render('ajax/coursecosts.html.twig', array('grupos' => $valores,));
    }
    
    /**
     * Carga los costos de los Tipos de Publicaciones en la moneda seleccionada
     *
     * @Route("/typespublications", name="ajax_typespublications")
     * @Method({"POST"})
     */
    public function typespublicationsAction(Request $request) {
        $id =$request->request->get('id');

        $em = $this->getDoctrine()->getManager();
        
        $grupos = $em->getRepository('AppBundle:Typespublications')->findByCurrency($id);
        
        $valores = '<option value="" selected="selected">Seleccione</option> ';
        
        foreach ($grupos as $valor) {
            $valores = $valores . ' <option value=' . $valor->getId() . '>' . $valor->getName() . ' | ' . $valor->getCurrency()->getName().' '. $valor->getPrice() . '</option> ';
        }
        return $this->render('ajax/coursecosts.html.twig', array('grupos' => $valores,));
    }

}
