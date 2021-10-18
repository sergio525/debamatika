<?php

namespace App\Controller;

use App\Entity\Campo;
use App\Entity\Bloque;
use App\Entity\Informe;
use App\Entity\EquipoInstalado;
use App\Entity\VariableInforme;
use App\Form\CampoType;
use App\Form\PlantillaType;
use App\Repository\CampoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/campo")
 */
class CampoController extends AbstractController
{
    /**
     * @Route("/ordenar", name="campo_ordenar", methods={"POST"})
     */
    public function ordenar(CampoRepository $campoRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        
        $datos = $_POST['datos'];
        $currentOrden = 1;
        foreach ($datos as $dato){
            $item = $em->getRepository('App:Variable')->find($dato['id']);
            
            $item->setOrden($currentOrden);
            $em->persist($item);
            $currentOrden ++;
        }
        $em->flush();
        
        return new Response();
        
    }
    
    /**
     * @Route("/", name="campo_index", methods={"GET"})
     */
    public function index(CampoRepository $campoRepository): Response
    {
        return $this->render('campo/index.html.twig', [
            'campos' => $campoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{bloque}", name="campo_new", methods={"GET","POST"})
     */
    public function new(Request $request, Bloque $bloque): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $campo = new Campo();
        $campo->setBloque($bloque);
        $campo->setOrden($bloque->getOrdenNuevo());
        $form = $this->createForm(CampoType::class, $campo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($campo);
            $entityManager->flush();

            $this->forward('App\Controller\PlantillaController::campoNew', [
                'campo' => $campo->getId()
            ]);
            
            return $this->redirectToRoute('campo_show', ['id' => $campo->getId()]);
        }

        return $this->render('campo/new.html.twig', [
            'campo' => $campo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="campo_show", methods={"GET"})
     */
    public function show(Campo $campo): Response
    {
        return $this->render('campo/show.html.twig', [
            'campo' => $campo,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="campo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Campo $campo): Response
    {
        $form = $this->createForm(CampoType::class, $campo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('campo_show', ['id' => $campo->getId()]);
        }

        return $this->render('campo/edit.html.twig', [
            'campo' => $campo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="campo_delete", methods={"POST"})
     */
    public function delete(Request $request, Campo $campo): Response
    {
        $this->forward('App\Controller\PlantillaController::campoDelete', [
            'campo' => $campo->getId()
        ]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($campo);
        $entityManager->flush();

        return new Response();
    }
    
    /**
     * @Route("/plantilla/{id}-{equipo}", name="campo_plantilla", methods={"GET"})
     */
    public function plantilla(Campo $campo, EquipoInstalado $equipo): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $plantilla = $em->getRepository('App:Plantilla')->findOneBy(['idItem' => $campo->getId(), 'tipoItem' => 'campo', 'equipo' => $equipo->getId()]);
        $form = $this->createForm(PlantillaType::class, $plantilla);
        
        return $this->render('campo/plantilla/edit.html.twig', [
            'campo' => $campo,
            'equipo' => $equipo,
            'plantilla' => $plantilla,
            'form' => $form->createView(),
        ]);
    }
    
     /**
     * @Route("/informe/{id}-{informe}", name="campo_informe", methods={"GET"})
     */
    public function informe(Campo $campo, Informe $informe): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $plantilla = $em->getRepository('App:Plantilla')->findOneBy([
            'idItem' => $campo->getId(), 
            'tipoItem' => 'campo', 
            'equipo' => $informe->getEquipo()->getId()
        ]);
        
        
        
        if ($plantilla->getVisible() && count($campo->getVariables()) > 0){
            $variablesInforme = [];
            $variables = $campo->getVariables();
            
            foreach ($variables as $variable){
                $variableInforme = $em->getRepository('App:VariableInforme')->findOneBy([
                    'informe' => $informe->getId(), 
                    'campo' => $campo->getId(), 
                    'variable' => $variable->getId()
                ]);
                
                if (is_null($variableInforme)){
                    $variableInforme = new VariableInforme();
                    $variableInforme->setCampo($campo);
                    $variableInforme->setInforme($informe);
                    $variableInforme->setVariable($variable);
                    $variableInforme->setValor('');
                    if ($variable->getTipoCampo()->getNombre() == 'Valor')
                        $variableInforme->setValor(is_null($variable->getValorDefecto())?'':$variable->getValorDefecto());
                    
                    $em->persist($variableInforme);
                    $em->flush();
                }
                
                $variablesInforme[] = $variableInforme;
                
            }
            
            return $this->render('campo/informe/edit.html.twig', [
                'campo' => $campo,
                'informe' => $informe,
                'variables' => $variablesInforme,

            ]);
        }
        
        return new Response();
    }
    
    /**
     * @Route("/print/{id}-{informe}", name="campo_print", methods={"GET"})
     */
    public function print(Campo $campo, Informe $informe): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $plantilla = $em->getRepository('App:Plantilla')->findOneBy([
            'idItem' => $campo->getId(), 
            'tipoItem' => 'campo', 
            'equipo' => $informe->getEquipo()->getId()
        ]);
        
        
        
        if ($plantilla->getVisible() && count($campo->getVariables()) > 0){
            $variablesInforme = [];
            $variables = $campo->getVariables();
            
            foreach ($variables as $variable){
                $variableInforme = $em->getRepository('App:VariableInforme')->findOneBy([
                    'informe' => $informe->getId(), 
                    'campo' => $campo->getId(), 
                    'variable' => $variable->getId()
                ]);
                
                if (is_null($variableInforme)){
                    $variableInforme = new VariableInforme();
                    $variableInforme->setCampo($campo);
                    $variableInforme->setInforme($informe);
                    $variableInforme->setVariable($variable);
                    $variableInforme->setValor('');
                    if ($variable->getTipoCampo()->getNombre() == 'Valor')
                        $variableInforme->setValor(is_null($variable->getValorDefecto())?'':$variable->getValorDefecto());
                    
                    $em->persist($variableInforme);
                    $em->flush();
                }
                
                $variablesInforme[] = $variableInforme;
                
            }
            
            return $this->render('campo/informe/print.html.twig', [
                'campo' => $campo,
                'informe' => $informe,
                'variables' => $variablesInforme,

            ]);
        }
        
        return new Response();
    }
}
