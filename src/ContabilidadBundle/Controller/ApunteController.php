<?php

namespace ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

//use ContabilidadBundle\Entity\Asiento;
//use ContabilidadBundle\Entity\Asiento;

class ApunteController extends Controller
{
	private $sesion;
    
    public function __construct(){
        $this->sesion = new Session();
    }

    public function QueryAction($asiento_id) {
        $em = $this->getDoctrine()->getManager();
        $Asiento_repo = $em->getRepository("ContabilidadBundle:Asiento");
        $Apunte_repo = $em->getRepository("ContabilidadBundle:Apunte");
        
        $Asiento = $Asiento_repo->find($asiento_id);
        $Apuntes = $Apunte_repo->queryByAsiento($asiento_id);
        
        return $this->render ('ContabilidadBundle:Apunte:query.html.twig', 
                                ["Asiento" => $Asiento,
                                 "Apuntes" => $Apuntes ]);
                
    }
}
  