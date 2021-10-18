<?php

namespace App\Controller;

use App\Entity\Bloque;
use App\Entity\Protocolo;
use App\Entity\EquipoInstalado;
use App\Entity\Informe;
use App\Form\BloqueType;
use App\Form\PlantillaType;
use App\Repository\BloqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bloque")
 */
class BloqueController extends AbstractController
{
    /**
     * @Route("/ordenar/{protocolo}/{bloqueParent}", name="bloque_ordenar", methods={"GET", "POST"})
     */
    public function ordenar(Request $request, Protocolo $protocolo, Bloque $bloqueParent = null): Response
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('get')) {
            $items = [];
            
            $bloques = $em->getRepository('App:Bloque')->findBy([ 'bloquePadre' => $bloqueParent,'protocolo' => $protocolo]);
            foreach ($bloques as $item){
                $items[$item->getOrden()] = ['tipo' => 'bloque', 'id' => $item->getId(), 'nombre' => $item->getTitulo()];
            }
            
            $campos = $em->getRepository('App:Campo')->findBy(['bloque' => $bloqueParent]);
            foreach ($campos as $item){
                $items[$item->getOrden()] = ['tipo' => 'campo', 'id' => $item->getId(), 'nombre' => $item->getTitulo()];
            }

            ksort($items);
            return $this->render('bloque/ordenar.html.twig', [
                'items' => $items,
            ]);
        }
        
        $datos = $_POST['datos'];
        $currentOrden = 1;
        foreach ($datos as $dato){
            if ($dato['tipo'] == 'bloque'){
                $item = $em->getRepository('App:Bloque')->find($dato['id']);
            }
            else if ($dato['tipo'] == 'campo'){
                $item = $em->getRepository('App:Campo')->find($dato['id']);
            }
            
            $item->setOrden($currentOrden);
            $em->persist($item);
            $currentOrden ++;
        }
        $em->flush();
        
        return new Response();
        
    }
    
    /**
     * @Route("/", name="bloque_index", methods={"GET"})
     */
    public function index(BloqueRepository $bloqueRepository): Response
    {
        return $this->render('bloque/index.html.twig', [
            'bloques' => $bloqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{protocolo}/{bloqueParent}", name="bloque_new", methods={"GET","POST"})
     */
    public function new(Request $request, Protocolo $protocolo, Bloque $bloqueParent = null): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
            
        $bloque = new Bloque();
        $bloque->setProtocolo($protocolo);
        $orden = $protocolo->getOrdenNuevo();
        if(!is_null($bloqueParent)){
            $bloque->setBloquePadre($bloqueParent);
            $orden = $bloqueParent->getOrdenNuevo();
        }
        $bloque->setOrden($orden);
       

        $form = $this->createForm(BloqueType::class, $bloque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bloque);
            $entityManager->flush();

            $this->forward('App\Controller\PlantillaController::bloqueNew', [
                'bloque' => $bloque->getId()
            ]);
            
            return $this->redirectToRoute('bloque_show', ['id' => $bloque->getId()]);
        }

        return $this->render('bloque/new.html.twig', [
            'bloque' => $bloque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bloque_show", methods={"GET"})
     */
    public function show(Bloque $bloque): Response
    {
        return $this->render('bloque/show.html.twig', [
            'bloque' => $bloque,
        ]);
    }
    
    /**
     * @Route("/edit/{id}", name="bloque_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bloque $bloque): Response
    {
        $form = $this->createForm(BloqueType::class, $bloque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bloque_show', ['id' => $bloque->getId()]);
        }

        return $this->render('bloque/edit.html.twig', [
            'bloque' => $bloque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="bloque_delete", methods={"POST"})
     */
    public function delete(Request $request, Bloque $bloque): Response
    {
        $this->forward('App\Controller\PlantillaController::bloqueDelete', [
            'bloque' => $bloque->getId()
        ]);
               
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($bloque);
        $entityManager->flush();

        return new Response();
    }
    
    /**
     * @Route("/plantilla/{id}-{equipo}", name="bloque_plantilla", methods={"GET"})
     */
    public function plantilla(Bloque $bloque, EquipoInstalado $equipo): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $plantilla = $em->getRepository('App:Plantilla')->findOneBy(['idItem' => $bloque->getId(), 'tipoItem' => 'bloque', 'equipo' => $equipo->getId()]);
        $form = $this->createForm(PlantillaType::class, $plantilla);
        
        return $this->render('bloque/plantilla/edit.html.twig', [
            'bloque' => $bloque,
            'equipo' => $equipo,
            'plantilla' => $plantilla,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/informe/{id}-{informe}", name="bloque_informe", methods={"GET"})
     */
    public function informe(Bloque $bloque, Informe $informe): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $plantilla = $em->getRepository('App:Plantilla')->findOneBy([
            'idItem' => $bloque->getId(), 
            'tipoItem' => 'bloque', 
            'equipo' => $informe->getEquipo()->getId()
        ]);
        
        if ($plantilla->getVisible()) {
            return $this->render('bloque/informe/edit.html.twig', [
                'bloque' => $bloque,
                'informe' => $informe,
            ]);
        }
        
        return new Response();
    }
    
    /**
     * @Route("/print/{id}-{informe}", name="bloque_print", methods={"GET"})
     */
    public function print(Bloque $bloque, Informe $informe): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $plantilla = $em->getRepository('App:Plantilla')->findOneBy([
            'idItem' => $bloque->getId(), 
            'tipoItem' => 'bloque', 
            'equipo' => $informe->getEquipo()->getId()
        ]);
        
        if ($plantilla->getVisible()) {
            return $this->render('bloque/informe/print.html.twig', [
                'bloque' => $bloque,
                'informe' => $informe,
            ]);
        }
        
        return new Response();
    }

}
