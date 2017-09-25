<?php

namespace ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

use ContabilidadBundle\Entity\Ejercicio;

class EjercicioController extends Controller
{
	private $sesion;
    
    public function __construct(){
        $this->sesion = new Session();
    }

    public function QueryAction() {
        $em = $this->getDoctrine()->getManager();
        $Ejercicio_repo = $em->getRepository("ContabilidadBundle:Ejercicio");
        
        $Ejercicios = $Ejercicio_repo->findAll();
        
        return $this->render ('ContabilidadBundle:Ejercicio:query.html.twig', ["Ejercicios" => $Ejercicios]);
                
    }
}
  