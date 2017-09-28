<?php

namespace ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

use ContabilidadBundle\Entity\Ejercicio;
use ContabilidadBundle\Form\EjercicioType;
use ContabilidadBundle\Form\EditEjercicioType;
use Symfony\Component\HttpFoundation\Request;


class EjercicioController extends Controller
{
	private $sesion;
    
    public function __construct(){
        $this->sesion = new Session();
    }

    public function ActualAction($ejercicio_id){
        $EntityManager = $this->getDoctrine()->getManager();
        $EjercicioActual_repo = $EntityManager->getRepository("ContabilidadBundle:EjercicioActual");
        $Ejercicio_repo = $EntityManager->getRepository("ContabilidadBundle:Ejercicio");
        $EjercicioActual = $EjercicioActual_repo->find(1);
        $Ejercicio = $Ejercicio_repo->find($ejercicio_id);
        $EjercicioActual->setEjercicio($Ejercicio);
        $EntityManager->persist($EjercicioActual);
        $EntityManager->flush();
        
        $status = "EJERCICIO ". $Ejercicio->getDescripcion()." ESTABLECIDO COMO ACTUAL";
        $this->sesion->getFlashBag()->add("status",$status);
        return $this->redirectToRoute("queryEjercicio");
    }

    public function QueryAction() { 
        $em = $this->getDoctrine()->getManager();
        $Ejercicio_repo = $em->getRepository("ContabilidadBundle:Ejercicio");
        
        $Ejercicios = $Ejercicio_repo->findAll();
        return $this->render ('ContabilidadBundle:Ejercicio:query.html.twig', ["Ejercicios" => $Ejercicios]);
    }
    
    public function AddAction(Request $request){
        $EntityManager = $this->getDoctrine()->getManager();
        $Ejercicio_repo = $EntityManager->getRepository("ContabilidadBundle:Ejercicio");
        $EstadoEjercicio_repo = $EntityManager->getRepository("ContabilidadBundle:EstadoEjercicio");
        
        $Ejercicio = new Ejercicio();
        $EjercicioForm =  $this->createForm(EjercicioType::class, $Ejercicio);
        $EjercicioForm->handleRequest($request);
        if ($EjercicioForm->isSubmitted()){
            $Ejercicio = new Ejercicio();
            $Ejercicio->setDescripcion($EjercicioForm->get('descripcion')->getData());
            $Ejercicio->setFcini($EjercicioForm->get('fcini')->getData());
            $Ejercicio->setFcfin($EjercicioForm->get('fcfin')->getData());
     
            $EstadoEjercicio = $EstadoEjercicio_repo->find($EjercicioForm->get('estadoEjercicio')->getData());
            $Ejercicio->setEstadoEjercicio($EstadoEjercicio);
            
            $EntityManager->persist($Ejercicio);
            $EntityManager->flush();
            
            $status = "EJERCICIO CREADO CORRECTAMENTE";
            $this->sesion->getFlashBag()->add("status",$status);
                return $this->redirectToRoute("queryEjercicio");
                
           }
                
        return $this->render("ContabilidadBundle:Ejercicio:add.html.twig", array(
            "form" => $EjercicioForm->createView()
        ));        
    }
    
    public function EditAction(Request $request, $id){
        $EntityManager = $this->getDoctrine()->getManager();
        $Ejercicio_repo = $EntityManager->getRepository("ContabilidadBundle:Ejercicio");
        $EstadoEjercicio_repo = $EntityManager->getRepository("ContabilidadBundle:EstadoEjercicio");

        $Ejercicio = $Ejercicio_repo->find($id);
        $EjercicioForm = $this->createForm(EditEjercicioType::class, $Ejercicio);
        $EjercicioForm->handleRequest($request);
        
        if ($EjercicioForm->isSubmitted()){
            $Ejercicio->setDescripcion($EjercicioForm->get('descripcion')->getData());
            $Ejercicio->setFcini($EjercicioForm->get('fcini')->getData());
            $Ejercicio->setFcfin($EjercicioForm->get('fcfin')->getData());
     
            $EstadoEjercicio = $EstadoEjercicio_repo->find($EjercicioForm->get('estadoEjercicio')->getData());
            $Ejercicio->setEstadoEjercicio($EstadoEjercicio);
            
            $EntityManager->persist($Ejercicio);
            $EntityManager->flush();
            
            $status = "EJERCICIO MODIFICADO CORRECTAMENTE";
            $this->sesion->getFlashBag()->add("status",$status);
            return $this->redirectToRoute("queryEjercicio");
        }
                
        return $this->render("ContabilidadBundle:Ejercicio:edit.html.twig", array(
            "form" => $EjercicioForm->createView(),
            "Ejercicio" => $Ejercicio
        ));        
    }
    

    
}
  