<?php

namespace ContabilidadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

use ContabilidadBundle\Entity\CuentaMayor;
use ContabilidadBundle\Form\CuentaMayorType;
use Symfony\Component\HttpFoundation\Request;


class CuentaMayorController extends Controller
{
	private $sesion;
    
    public function __construct(){
        $this->sesion = new Session();
    }

    public function QueryAction() { 
        $em = $this->getDoctrine()->getManager();
        $CuentaMayor_repo = $em->getRepository("ContabilidadBundle:CuentaMayor");
        
        $CuentasMayor = $CuentaMayor_repo->findAll();
        return $this->render ('ContabilidadBundle:CuentaMayor:query.html.twig', ["CuentasMayor" => $CuentasMayor]);
    }
    
    public function AddAction(Request $request){
        $EntityManager = $this->getDoctrine()->getManager();
        $CuentaMayor_repo = $EntityManager->getRepository("ContabilidadBundle:CuentaMayor");
        $EstadoCuentaMayor_repo = $EntityManager->getRepository("ContabilidadBundle:EstadoCuentaMayor");
        
        $CuentaMayor = new CuentaMayor();
        $CuentaMayorForm =  $this->createForm(CuentaMayorType::class, $CuentaMayor);
        $CuentaMayorForm->handleRequest($request);
        if ($CuentaMayorForm->isSubmitted()){
            $CuentaMayor = new CuentaMayor();
            $CuentaMayor->setDescripcion($CuentaMayorForm->get('descripcion')->getData());
            $CuentaMayor->setFcini($CuentaMayorForm->get('fcini')->getData());
            $CuentaMayor->setFcfin($CuentaMayorForm->get('fcfin')->getData());
     
            $EstadoCuentaMayor = $EstadoCuentaMayor_repo->find($CuentaMayorForm->get('estadoCuentaMayor')->getData());
            $CuentaMayor->setEstadoCuentaMayor($EstadoCuentaMayor);
            
            $EntityManager->persist($CuentaMayor);
            $EntityManager->flush();
            
            $status = "EJERCICIO CREADO CORRECTAMENTE";
            $this->sesion->getFlashBag()->add("status",$status);
            return $this->redirectToRoute("queryCuentaMayor");
                
           }
                
        return $this->render("ContabilidadBundle:CuentaMayor:add.html.twig", array(
            "form" => $CuentaMayorForm->createView()
        ));        
    }
    
    public function EditAction(Request $request, $id){
        $EntityManager = $this->getDoctrine()->getManager();
        $CuentaMayor_repo = $EntityManager->getRepository("ContabilidadBundle:CuentaMayor");
        $GrupoCuenta_repo = $EntityManager->getRepository("ContabilidadBundle:GrupoCuenta");
        $TipoCuenta_repo = $EntityManager->getRepository("ContabilidadBundle:TipoCuenta");

        $CuentaMayor = $CuentaMayor_repo->find($id);
        $CuentaMayorForm = $this->createForm(CuentaMayorType::class, $CuentaMayor);
        $CuentaMayorForm->handleRequest($request);
        
        if ($CuentaMayorForm->isSubmitted()){
            $CuentaMayor->setCodigo($CuentaMayorForm->get('codigo')->getData());
            $CuentaMayor->setDescripcion($CuentaMayorForm->get('descripcion')->getData());
            
            $grupoCuenta_id = $CuentaMayorForm->get('grupoCuenta')->getData();
            if ($grupoCuenta_id) {
                $GrupoCuenta = $GrupoCuenta_repo->find($grupoCuenta_id);
                $CuentaMayor->setGrupoCuenta($GrupoCuenta);
            }
            
            $tipoCuenta_id = $CuentaMayorForm->get('tipoCuenta')->getData();
            if ($grupoCuenta_id) {
                $TipoCuenta = $TipoCuenta_repo->find($tipoCuenta_id);
                $CuentaMayor->setTipoCuenta($TipoCuenta);
            }
            
            $EntityManager->persist($CuentaMayor);
            $EntityManager->flush();
            
            $status = "CUENTA DE MAYOR MODIFICADA CORRECTAMENTE";
            $this->sesion->getFlashBag()->add("status",$status);
            return $this->redirectToRoute("queryCuentaMayor");
        }
                
        return $this->render("ContabilidadBundle:CuentaMayor:edit.html.twig", array(
            "form" => $CuentaMayorForm->createView(),
            "CuentaMayor" => $CuentaMayor
        ));        
    }
    

    
}
  