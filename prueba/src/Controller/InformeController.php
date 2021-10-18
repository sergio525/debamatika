<?php

namespace App\Controller;

use App\Entity\Informe;
use App\Entity\EquipoInstalado;
use App\Entity\VariableInforme;
use App\Form\InformeType;
use App\Repository\InformeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/informe")
 */
class InformeController extends AbstractController
{
    /**
     * @Route("/{equipo}", name="informe_index", methods={"GET"})
     */
    public function index(InformeRepository $informeRepository, EquipoInstalado $equipo): Response
    {
        return $this->render('informe/index.html.twig', [
            'informes' => $informeRepository->findBy(['equipo' => $equipo], ['fecha' => 'ASC']),
            'equipo' => $equipo,
        ]);
    }

    /**
     * @Route("/new/{equipo}", name="informe_new", methods={"GET","POST"})
     */
    public function new(Request $request, EquipoInstalado $equipo): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $informe = new Informe();
        $informe->setEquipo($equipo);
        $informe->setEstado('proceso');
        $informe->setNumeroRevision($equipo->getNumeroRevision() + 1);
        
       
        $form = $this->createForm(InformeType::class, $informe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($informe);
            $entityManager->flush();
            
            $equipo->setNumeroRevision($equipo->getNumeroRevision() + 1);
            $entityManager->persist($equipo);
            $entityManager->flush();

            return $this->redirectToRoute('informe_index', ['equipo' => $equipo->getId()]);
        }
        
        
        return $this->render('informe/new.html.twig', [
            'informe' => $informe,
            'equipo' => $equipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="informe_show", methods={"GET"})
     */
    public function show(Informe $informe): Response
    {
        return $this->render('informe/show.html.twig', [
            'informe' => $informe,
        ]);
    }
    
    /**
     * @Route("/ayuda/{tipo}/{id}", name="informe_ayuda", methods={"GET"})
     */
    public function ayuda( $tipo, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($tipo == 'bloque')
            $item = $em->getRepository('App:Bloque')->find($id);
        else
            $item = $em->getRepository('App:Campo')->find($id);
        
        $result['titulo'] = $item->getTitulo();
        $result['mensaje'] = $item->getAyuda();
        
        return new \Symfony\Component\HttpFoundation\JsonResponse($result);
    }

    /**
     * @Route("/{id}/edit", name="informe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Informe $informe): Response
    {
        $form = $this->createForm(InformeType::class, $informe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('informe_index');
        }

        return $this->render('informe/edit.html.twig', [
            'informe' => $informe,
            'equipo' => $informe->getEquipo(),
            'instalacion' => $informe->getEquipo()->getInstalacion(),
            'cliente' => $informe->getEquipo()->getInstalacion()->getCliente()
        ]);
    }
    
    /**
     * @Route("/print/{id}", name="informe_print", methods={"GET","POST"})
     */
    public function print(Request $request, Informe $informe): Response
    {
        $form = $this->createForm(InformeType::class, $informe);
        $form->handleRequest($request);

        
        return $this->render('informe/print.html.twig', [
            'informe' => $informe,
            'equipo' => $informe->getEquipo(),
            'instalacion' => $informe->getEquipo()->getInstalacion(),
            'cliente' => $informe->getEquipo()->getInstalacion()->getCliente()
        ]);
    }
    
    /**
     * @Route("/save-var/{variable}/{valor}", name="informe_save_variable", methods={"GET"})
     */
    public function saveVariable(Request $request, VariableInforme $variable, $valor=''): Response
    {
        $em = $this->getDoctrine()->getManager();
        
        $variable->setValor($valor);
       
        $em->persist($variable);
        $em->flush();
        
        return new JsonResponse();
    }

    /**
     * @Route("/{informe}/{variable}", name="informe_variable_anterior", methods={"GET"})
     */
    public function variableAnterior(Request $request, Informe $informe, VariableInforme $variable): Response
    {
        $em = $this->getDoctrine()->getManager();
        
        $informeAnterior = $em->getRepository('App:Informe')->findOneBy([
            'equipo' => $informe->getEquipo(),
            'numeroRevision' => $informe->getNumeroRevision() - 1,
        ]);
        
        $variableAnterior = null;
        if (!is_null($informeAnterior)){
            $variableAnterior = $em->getRepository('App:VariableInforme')->findOneBy([
                'informe' => $informeAnterior->getId(),
                'variable' => $variable->getVariable()->getId(),
            ]);
        }
        
        return $this->render('variable/informe/variableAnterior.html.twig', [
            'variable' => $variableAnterior,    
            'variableActual' => $variable,  
        ]);
    }
    
    /**
     * @Route("/{id}", name="informe_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Informe $informe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$informe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($informe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('informe_index');
    }
}
