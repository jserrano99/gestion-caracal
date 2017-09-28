<?php

namespace ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

use ContabilidadBundle\Entity\Proyecto;
use ContabilidadBundle\Form\ProyectoType;

class ProyectoController extends Controller
{
	private $sesion;
    
    public function __construct(){
        $this->sesion = new Session();
    }

    public function QueryAction() {
        $em = $this->getDoctrine()->getManager();
        $Proyecto_repo = $em->getRepository("ContabilidadBundle:Proyecto");
        $Proyectos = $Proyecto_repo->findAll();
        $params = ['Proyectos' => $Proyectos];
        return $this->render ('ContabilidadBundle:Proyecto:query.html.twig', $params);
    }
    
    public function AddAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $Proyecto_repo = $em->getRepository("ContabilidadBundle:Proyecto");
        $Proyecto = new Proyecto();
        $ProyectoForm = $this->createForm(ProyectoType::class,$Proyecto);
        $ProyectoForm->handleRequest($request);
        if ($ProyectoForm->isSubmitted()) {
            $Proyecto = new Proyecto();
            $Proyecto->setDescripcion($ProyectoForm->get('descripcion')->getData());
            $em->persist($Proyecto);
            $em->flush();
            $status = "PROYECTO CREEADO CORRECTAMENTE";
            $this->sesion->getFlashBag()->add("status",$status);
            return $this->redirectToRoute("queryProyecto");
        }
        $params = ["form" => $ProyectoForm->createView()];
        $view = "ContabilidadBundle:Proyecto:add.html.twig";
        return $this->render($view,$params);
    }
    
    public function EditAction(Request $request,$id) {
        $em = $this->getDoctrine()->getManager();
        $Proyecto_repo = $em->getRepository("ContabilidadBundle:Proyecto");
        
        $Proyecto = $Proyecto_repo->find($id);
        $ProyectoForm = $this->createForm(ProyectoType::class,$Proyecto);
        $ProyectoForm->handleRequest($request);
        
        if ($ProyectoForm->isSubmitted()) {
            $Proyecto->setDescripcion($ProyectoForm->get('descripcion')->getData());
            
            $em->persist($Proyecto);
            $em->flush();
            
            $status = "PROYECTO MODIFICADO CORRECTAMENTE";
            $this->sesion->getFlashBag()->add("status",$status);
                return $this->redirectToRoute("queryProyecto");
        }
        
        $params = ["form" => $ProyectoForm->createView(),
                   "Proyecto" => $Proyecto ];
        $view = "ContabilidadBundle:Proyecto:edit.html.twig";
        return $this->render($view,$params);
    }
    
    
    public function DeleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $Proyecto_repo = $em->getRepository("ContabilidadBundle:Proyecto");
        
        $Proyecto = $Proyecto_repo->find($id);
        $em->remove($Proyecto);
        $em->flush();
        $status = "PROYECTO ELIMINADO CORRECTAMENTE";
        $this->sesion->getFlashBag()->add("status",$status);
        return $this->redirectToRoute("queryProyecto");
    }
}
  