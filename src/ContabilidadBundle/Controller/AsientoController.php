<?php

namespace ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

//use ContabilidadBundle\Entity\Asiento;
use ContabilidadBundle\Entity\Asiento;

class AsientoController extends Controller
{
	private $sesion;
    
    public function __construct(){
        $this->sesion = new Session();
    }

    public function QueryAction($ejercicio_id) {
        $em = $this->getDoctrine()->getManager();
        $Ejercicio_repo = $em->getRepository("ContabilidadBundle:Ejercicio");
        $Asiento_repo = $em->getRepository("ContabilidadBundle:Asiento");
        
        $Ejercicio = $Ejercicio_repo->find($ejercicio_id);
        $Asientos = $Asiento_repo->queryByEjercicio($ejercicio_id);
        
        return $this->render ('ContabilidadBundle:Asiento:query.html.twig', 
                               ["Ejercicio"=> $Ejercicio,  
                                "Asientos" => $Asientos]);
                
    }
}
  