<?php

namespace App\Controller;

use App\Entity\Plantilla;
use App\Entity\Bloque;
use App\Entity\Campo;
use App\Entity\TipoEquipo;
use App\Entity\EquipoInstalado;
use App\Entity\Protocolo;

use App\Repository\ClienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/plantilla")
 */
class PlantillaController extends AbstractController
{
  
    /* Función que devuelve los equipos instalados de un tipo dado */
    private function getEquipos(TipoEquipo $tipo){
        $em = $this->getDoctrine()->getManager();
        $equipos = $em->getRepository('App:EquipoInstalado')->findAll();
        
        $result = [];
        foreach ($equipos as $equipo){
            if ($equipo->getTipoEquipo() === $tipo){
                $result[] = $equipo;
            }
        }
        
        return $result;
    }
            
    /**
     * @Route("/bloque-new/{bloque}", name="plantilla_bloque_new", methods={"GET"})
     */
    public function bloqueNew(Bloque $bloque): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $equipos = $this->getEquipos($bloque->getProtocolo()->getTipoEquipo());
        
        foreach ($equipos as $equipo){
            $plantilla = new Plantilla();
            $plantilla->setEquipo($equipo);
            $plantilla->setIdItem($bloque->getId());
            $plantilla->setTipoItem('bloque');
            $plantilla->setVisible(true);
            
            $em->persist($plantilla);
            $em->flush();
        }
        return new Response();
    }
    
    /**
     * @Route("/bloque-delete/{bloque}", name="plantilla_bloque_delete", methods={"GET"})
     */
    public function bloqueDelete(Bloque $bloque): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $plantillas = $em->getRepository('App:Plantilla')->findBy(['tipoItem' => 'bloque', 'idItem' => $bloque->getId()]);
        
        foreach ($plantillas as $plantilla) {
            $em->remove($plantilla);
        }
        
        $em->flush();
        
        return new Response();
    }
    
    /**
     * @Route("/campo-new/{campo}", name="plantilla_campo_new", methods={"GET"})
     */
    public function campoNew(Campo $campo): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $equipos = $this->getEquipos($campo->getBloque()->getProtocolo()->getTipoEquipo());
        
        foreach ($equipos as $equipo){
            $plantilla = new Plantilla();
            $plantilla->setEquipo($equipo);
            $plantilla->setIdItem($campo->getId());
            $plantilla->setTipoItem('campo');
            $plantilla->setVisible(true);
            
            $em->persist($plantilla);
            $em->flush();
        }
        return new Response();
    }
    
    /**
     * @Route("/campo-delete/{bloque}", name="plantilla_campo_delete", methods={"GET"})
     */
    public function campoDelete(Campo $campo): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $plantillas = $em->getRepository('App:Plantilla')->findBy(['tipoItem' => 'campo', 'idItem' => $campo->getId()]);
        
        foreach ($plantillas as $plantilla) {
            $em->remove($plantilla);
        }
        
        $em->flush();
        
        return new Response();
    }

    /**
     * @Route("/equipo-new/{equipo}", name="plantilla_equipo_new", methods={"GET"})
     */
    public function equipoNew(EquipoInstalado $equipo): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $protocolo = $em->getRepository('App:Protocolo')->findOneBy(['tipoEquipo' => $equipo->getTipoEquipo()->getId()]);
        
        var_dump($protocolo->getId());
        foreach ($protocolo->getBloques() as $bloque) {
            $this->insertBloque($bloque, $equipo);
        }
        return new Response();
    }
    
    private function insertBloque($bloque, $equipo){
        $em = $this->getDoctrine()->getManager();
        foreach($bloque->getBloques() as $bloqueHijo){
            
            $this->insertBloque($bloqueHijo, $equipo);
            
        }
        
        foreach($bloque->getCampos() as $campoHijo){
            $plantilla = new Plantilla();
            $plantilla->setEquipo($equipo);
            $plantilla->setIdItem($campoHijo->getId());
            $plantilla->setTipoItem('campo');
            $plantilla->setVisible(true);
            
            $em->persist($plantilla);
        }
        
        $plantilla = new Plantilla();
        $plantilla->setEquipo($equipo);
        $plantilla->setIdItem($bloque->getId());
        $plantilla->setTipoItem('bloque');
        $plantilla->setVisible(true);

        $em->persist($plantilla);
        $em->flush(); 
    }
    
    /**
     * @Route("/equipo-delete/{equipo}", name="plantilla_equipo_delete", methods={"GET"})
     */
    public function equipoDelete(EquipoInstalado $equipo): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $plantillas = $em->getRepository('App:Plantilla')->findBy(['equipo' => $equipo]);
        
        foreach ($plantillas as $plantilla) {
            $em->remove($plantilla);
        }
        
        $em->flush();
        
        return new Response();
    }
    
    /**
     * @Route("/show/{equipo}", name="plantilla_show", methods={"GET"})
     */
    public function show(EquipoInstalado $equipo): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $protocolo = $em->getRepository('App:Protocolo')->findOneBy(['tipoEquipo' => $equipo->getTipoEquipo()->getId()]);
        
        return $this->render('protocolo/plantilla/edit.html.twig', [
            'protocolo' => $protocolo,
            'equipo' => $equipo,
        ]);
        
    }
    
    /**
     * @Route("/visible", name="plantilla_visible", methods={"POST"})
     */
    public function visible(): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $plantilla = $em->getRepository('App:Plantilla')->find($_POST['id']);
        
        if ($_POST['valor'] == 'true')
            $plantilla->setVisible(true);
        else
            $plantilla->setVisible(false);
        
        $em->persist($plantilla);
        $em->flush();
        
        return new Response();
        
    }
    
}
