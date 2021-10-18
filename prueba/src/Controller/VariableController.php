<?php

namespace App\Controller;

use App\Entity\Variable;
use App\Entity\Campo;
use App\Form\VariableType;
use App\Repository\VariableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/variable")
 */
class VariableController extends AbstractController
{
    /**
     * @Route("/", name="variable_index", methods={"GET"})
     */
    public function index(VariableRepository $variableRepository): Response
    {
        return $this->render('variable/index.html.twig', [
            'variables' => $variableRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{campo}", name="variable_new", methods={"GET","POST"})
     */
    public function new(Request $request, Campo $campo): Response
    {
        $variable = new Variable();
        $variable->setCampo($campo);
        $variable->setOrden($campo->getOrdenNuevo());
        $form = $this->createForm(VariableType::class, $variable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($variable);
            $entityManager->flush();

            return $this->redirectToRoute('variable_show', ['id' => $variable->getId()]);
        }

        return $this->render('variable/new.html.twig', [
            'variable' => $variable,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="variable_show", methods={"GET"})
     */
    public function show(Variable $variable): Response
    {
        $valores = [];
        
        if ($variable->getTipoCampo()->getNombre() == 'Selección'){
            $valores = explode('/-/', $variable->getValorDefecto());
        }
        
        return $this->render('variable/show.html.twig', [
            'variable' => $variable,
            'valores' => $valores,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="variable_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Variable $variable): Response
    {
        $form = $this->createForm(VariableType::class, $variable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('variable_index');
        }

        return $this->render('variable/edit.html.twig', [
            'variable' => $variable,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="variable_delete", methods={"POST"})
     */
    public function delete(Request $request, Variable $variable): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($variable);
            $entityManager->flush();
        return new Response();
    }
}
