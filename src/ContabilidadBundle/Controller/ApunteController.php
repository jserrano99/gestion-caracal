<?php

namespace ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\HttpFoundation\Request;
use ContabilidadBundle\Form\ApunteType;

class ApunteController extends Controller
{
	private $sesion;
    
    public function __construct(){
        $this->sesion = new Session();
    }

    public function QueryAction($asiento_id) {
        $em = $this->getDoctrine()->getManager();
        $Apunte_repo = $em->getRepository("ContabilidadBundle:Apunte");
        $Asiento_repo = $em->getRepository("ContabilidadBundle:Asiento");
        
        $Asiento = $Asiento_repo->find($asiento_id);
        $Apuntes = $Apunte_repo->queryByAsiento($asiento_id);
        
        $params = ["Apuntes" => $Apuntes,
                   "Asiento" => $Asiento];
        return $this->render ('ContabilidadBundle:Apunte:query.html.twig', $params);
                
    }
    
    public function EditAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $Apunte_repo = $em->getRepository("ContabilidadBundle:Apunte");
        $CuentaMayor_repo = $em->getRepository("ContabilidadBundle:CuentaMayor");
        

        $Apunte = $Apunte_repo->find($id);
        $ApunteForm = $this->createForm(ApunteType::class,$Apunte);
        $ApunteForm->handleRequest($request);
        
        if ( $ApunteForm->isSubmitted()){
            $Apunte->getNumero($ApunteForm->get('numero')->getData());
            $Apunte->getDescripcion($ApunteForm->get('descripcion')->getData());
            $Apunte->getObservaciones($ApunteForm->get('observaciones')->getData());
            $Apunte->getImporteDebe($ApunteForm->get('importeDebe')->getData());
            $Apunte->getImporteHaber($ApunteForm->get('importeHaber')->getData());
            
            $cuentaDebe_id = $ApunteForm->get('cuentaDebe')->getData();
            if ($cuentaDebe_id )  {
                $CuentaDebe = $CuentaMayor_repo->find($cuentaDebe_id);
                $Apunte->setCuentaDebe($CuentaDebe);
            }
            
            $cuentaHaber_id = $ApunteForm->get('cuentaHaber')->getData();
            if ($cuentaHaber_id )  {
                $CuentaHaber =  $CuentaMayor_repo->find($cuentaHaber_id);
                $Apunte->setCuentaHaber($CuentaHaber);
            }
            
            $em->persist($Apunte);
            $em->flush();
            
            $status = "APUNTE MODIFICADO CORRECTAMENTE";
            $this->sesion->getFlashBag()->add("status",$status);
            $params = ["asiento_id" => $Apunte->getAsiento()->getId() ];
            return $this->redirectToRoute("queryApunte",$params);
        }
        
        $params = ["form" => $ApunteForm->createView(),
                   "Apunte" => $Apunte];
        
        return $this->render("ContabilidadBundle:Apunte:edit.html.twig", $params);
    }
    
}
  