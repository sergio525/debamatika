<?php

namespace App\Controller;

use App\Entity\Instalacion;
use App\Entity\Cliente;
use App\Form\InstalacionType;
use App\Repository\InstalacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/instalacion")
 */
class InstalacionController extends AbstractController
{
    /**
     * @Route("/{cliente}", name="instalacion_index", methods={"GET"})
     */
    public function index(InstalacionRepository $instalacionRepository, Cliente $cliente): Response
    {
        $em = $this->getDoctrine()->getManager();
        $instalaciones = $instalacionRepository->findBy(['cliente' => $cliente], ['descripcion' => 'ASC']);
        
        return $this->render('instalacion/index.html.twig', [
            'instalaciones' => $instalaciones,
            'cliente' => $cliente,
        ]);
    }

    /**
     * @Route("/new/{cliente}", name="instalacion_new", methods={"GET","POST"})
     */
    public function new(Request $request, Cliente $cliente): Response
    {
        $instalacion = new Instalacion();
        $instalacion->setCliente($cliente);
        
        $form = $this->createForm(InstalacionType::class, $instalacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($instalacion);
            $entityManager->flush();

            return $this->redirectToRoute('instalacion_index', ['cliente' => $cliente->getId()]);
        }

        return $this->render('instalacion/new.html.twig', [
            'instalacion' => $instalacion,
            'cliente' => $cliente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="instalacion_show", methods={"GET"})
     */
    public function show(Instalacion $instalacion): Response
    {
        return $this->render('instalacion/show.html.twig', [
            'instalacion' => $instalacion,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="instalacion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Instalacion $instalacion): Response
    {
        $form = $this->createForm(InstalacionType::class, $instalacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('instalacion_index', ['cliente' => $cliente]);
        }

        return $this->render('instalacion/edit.html.twig', [
            'instalacion' => $instalacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="instalacion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Instalacion $instalacion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$instalacion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($instalacion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('instalacion_index');
    }
}
