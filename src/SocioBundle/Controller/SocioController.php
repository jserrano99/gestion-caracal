<?php

namespace SocioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

use SocioBundle\Form\SocioType;
use SocioBundle\Entity\Socio;
use SocioBundle\Form\ModiSocioType;
use PersonaBundle\Entity\Arquero;
        
class SocioController extends Controller
{
    private $sesion;
    
    public function __construct(){
        $this->sesion = new Session(); 
    }
        
    public function QueryAction() {
		$EntityManager = $this->getDoctrine()->getManager();
		$Socio_repo = $EntityManager->getRepository("SocioBundle:Socio");
		$Socios = $Socio_repo->findAll();
        return $this->render('SocioBundle::query.html.twig' , array (
            "Socios" => $Socios 
        ));   
    }  
	
//	 
    public function AddAction(Request $request){
       $EntityManager = $this->getDoctrine()->getManager();
       $Socio_repo = $EntityManager->getRepository("SocioBundle:Socio");
	   $Persona_repo = $EntityManager->getRepository("PersonaBundle:Persona");
	   $Club_repo = $EntityManager->getRepository("CataBundle:Club");

       $Socio = new Socio(); 
       $Socio->setNmsocio($Socio_repo->siguienteSocio());
	
       $SocioForm =  $this->createForm(SocioType::class, $Socio);
       $SocioForm->handleRequest($request);
        if ($SocioForm->isSubmitted()){
           if ($SocioForm->isValid()){
               $newSocio = new Socio();
               $newSocio->setNmsocio($SocioForm->get('nmsocio')->getData());
               $newSocio->setFcalta($SocioForm->get('fcalta')->getData());
			   $newSocio->setFcbaja($SocioForm->get('fcbaja')->getData());
			   $newSocio->setLicenciaMonitor($SocioForm->get('licenciaMonitor')->getData());
			   $newSocio->setNumeroLicencia($SocioForm->get('numeroLicencia')->getData());
			   $newSocio->setObservaciones($SocioForm->get('observaciones')->getData());
			   	// upload file
				$file=$SocioForm["foto"]->getData();
				if(!empty($file) && $file!=null){
					$ext=$file->guessExtension();
					$file_name=time().".".$ext;
					$file->move("fotosSocio",$file_name);
					$newSocio->setFoto($file_name);
				}else{
					$newSocio->setFoto(null);
				}
				
			   $Persona = $Persona_repo->find($SocioForm->get('persona')->getData());
			   $newSocio->setPersona($Persona);
			   $Estado = $Estado_repo->find($SocioForm->get('estado')->getData());
			   $Socio->setEstado($Estado);
			   
			   $Arquero = new Arquero();
			   $Arquero->setPersona($Persona);
			   $Arquero->setLicencia($newSocio->getNumerolicencia());
			   $Club = $Club_repo->find(17);
			   $Arquero->setClub($Club);
			   $EntityManager->persist($Arquero);
               $EntityManager->persist($newSocio);
               $flush = $EntityManager->flush();
                 if ($flush == null ) {
                    $status = 'Socio Generado Correctamente';
                 } else  {
                    $status = 'Error en Creación';
                 }
                $this->sesion->getFlashBag()->add("status",$status);
                return $this->redirectToRoute("querySocio");
                
           }
        }
        
        return $this->render("SocioBundle::insert.html.twig", array(
            "form" => $SocioForm->createView()
        ));        
	}
//        
    public function EditAction(Request $request, $id) {
		$EntityManager = $this->getDoctrine()->getManager();
		$Socio_repo = $EntityManager->getRepository("SocioBundle:Socio");
		$Estado_repo = $EntityManager->getRepository("CataBundle:Estado");
		$Socio = $Socio_repo->find($id);

		$foto = $Socio->getFoto();
		$SocioForm =  $this->createForm(ModiSocioType::class, $Socio);
		$SocioForm->handleRequest($request);
		if ($SocioForm->isSubmitted()){
           if ($SocioForm->isValid()){
               $Socio->setNmsocio($SocioForm->get('nmsocio')->getData());
               $Socio->setFcalta($SocioForm->get('fcalta')->getData());
			   $Socio->setFcbaja($SocioForm->get('fcbaja')->getData());
			   $Socio->setLicenciaMonitor($SocioForm->get('licenciaMonitor')->getData());
			   $Socio->setNumeroLicencia($SocioForm->get('numeroLicencia')->getData());
			   $Socio->setObservaciones($SocioForm->get('observaciones')->getData());

				$file=$SocioForm["foto"]->getData();
				if($file!=null) {
					$ext=$file->guessExtension();
					$file_name=time().".".$ext;
					$file->move("fotosSocio",$file_name);
					$Socio->setFoto($file_name);
				} else {
					$Socio->setFoto($foto);
				}
						
			   $Estado = $Estado_repo->find($SocioForm->get('estado')->getData());
			   $Socio->setEstado($Estado);
			   
               $EntityManager->persist($Socio);
                $flush = $EntityManager->flush();
                 if ($flush == null ) {
                    $status = 'Socio Modificado Correctamente';
                 } else  {
                    $status = 'Error en Modificación';
                 }
                $this->sesion->getFlashBag()->add("status",$status);
                return $this->redirectToRoute("querySocio");
                
           }
        }
        
        return $this->render("SocioBundle::update.html.twig", array(
            "form" => $SocioForm->createView(),
            "Socio" => $Socio
        ));        
    }
    
//    public function DeleteAction($id){
//       $EntityManager = $this->getDoctrine()->getManager();
//       $Socio_repo = $EntityManager->getRepository("PersonaBundle:Socio");
//       $Socio = $Socio_repo->find($id);
//       
//       $EntityManager->remove($Socio);
//       $EntityManager->flush();
//       
//       $status = " PERSONA ELIMINADA CORRECTAMENTE ";
//       $this->sesion->getFlashBag()->add("status",$status);
//       return $this->redirectToRoute("querySocio");
//   }
    
}
