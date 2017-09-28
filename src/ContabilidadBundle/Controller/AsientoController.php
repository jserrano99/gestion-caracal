<?php

namespace ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

//use ContabilidadBundle\Entity\Asiento;
use ContabilidadBundle\Entity\Asiento;
use ContabilidadBundle\Form\AsientoType;
use ContabilidadBundle\Entity\EjercicioActual;
class AsientoController extends Controller
{
	private $sesion;
    
    public function __construct(){
        $this->sesion = new Session();
    }

    public function QueryAction($ejercicio_id) {
        $em = $this->getDoctrine()->getManager();
        $EjercicioActual_repo = $em->getRepository("ContabilidadBundle:EjercicioActual");
        $Ejercicio_repo = $em->getRepository("ContabilidadBundle:Ejercicio");
        $Asiento_repo = $em->getRepository("ContabilidadBundle:Asiento");
        
        if ($ejercicio_id == null ) {
            $EjercicioActual = $EjercicioActual_repo->find(1);
            $ejercicio_id = $EjercicioActual->getEjercicio()->getId();
        }
        
        $Ejercicio = $Ejercicio_repo->find($ejercicio_id);
        $Asientos = $Asiento_repo->queryByEjercicio($ejercicio_id);
        
        return $this->render ('ContabilidadBundle:Asiento:query.html.twig', 
                               ["Ejercicio"=> $Ejercicio,  
                                "Asientos" => $Asientos]);
                
    }
    
    public function EditAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $Ejercicio_repo = $em->getRepository("ContabilidadBundle:Ejercicio");
        $Asiento_repo = $em->getRepository("ContabilidadBundle:Asiento");
        
        $Asiento = $Asiento_repo->find($id);
        $AsientoForm = $this->createForm(AsientoType::class,$Asiento);
        $AsientoForm->handleRequest($request);
        if ( $AsientoForm->isSubmitted()){
            
        }
        
        $params = ["form" => $AsientoForm->createView(),
                   "Asiento" => $Asiento];
        
        return $this->render("ContabilidadBundle:Asiento:edit.html.twig", $params);
    }
    
    public function AddAction(Request $request, $id) {
        return;
    }
    
    public function DeleteAction(Request $request, $id) {
        return;
    }
}
  