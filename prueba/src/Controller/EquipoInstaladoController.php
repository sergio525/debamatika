<?php

namespace App\Controller;

use App\Entity\EquipoInstalado;
use App\Entity\Instalacion;
use App\Form\EquipoInstaladoType;
use App\Repository\EquipoInstaladoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipo-instalado")
 */
class EquipoInstaladoController extends AbstractController
{
    /**
     * @Route("/{instalacion}", name="equipo_instalado_index", methods={"GET"})
     */
    public function index(EquipoInstaladoRepository $equipoInstaladoRepository, Instalacion $instalacion): Response
    {
        
        return $this->render('equipo_instalado/index.html.twig', [
            'equipo_instalados' => $equipoInstaladoRepository->findBy(['instalacion' => $instalacion], ['descripcion' => 'ASC']),
            'instalacion' => $instalacion,
        ]);
    }

    /**
     * @Route("/new/{instalacion}", name="equipo_instalado_new", methods={"GET","POST"})
     */
    public function new(Request $request, Instalacion $instalacion): Response
    {
        $equipoInstalado = new EquipoInstalado();
        $equipoInstalado->setInstalacion($instalacion);
        $form = $this->createForm(EquipoInstaladoType::class, $equipoInstalado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipoInstalado);
            $entityManager->flush();

            $this->forward('App\Controller\PlantillaController::equipoNew', [
                'equipo' => $equipoInstalado->getId()
            ]);
            
            return $this->redirectToRoute('equipo_instalado_index', ['instalacion' => $instalacion->getId()]);
        }

        return $this->render('equipo_instalado/new.html.twig', [
            'equipo_instalado' => $equipoInstalado,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="equipo_instalado_show", methods={"GET"})
     */
    public function show(EquipoInstalado $equipoInstalado): Response
    {
        return $this->render('equipo_instalado/show.html.twig', [
            'equipo_instalado' => $equipoInstalado,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="equipo_instalado_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EquipoInstalado $equipoInstalado): Response
    {
        $form = $this->createForm(EquipoInstaladoType::class, $equipoInstalado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipo_instalado_index', ['instalacion' => $equipoInstalado->getInstalacion()->getId()]);
        }

        return $this->render('equipo_instalado/edit.html.twig', [
            'equipo_instalado' => $equipoInstalado,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="equipo_instalado_delete", methods={"GET"})
     */
    public function delete(Request $request, EquipoInstalado $equipoInstalado): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $this->forward('App\Controller\PlantillaController::equipoDelete', [
            'equipo' => $equipoInstalado->getId()
        ]);
        $entityManager->remove($equipoInstalado);
        $entityManager->flush();
        
        return $this->redirectToRoute('equipo_instalado_index');
    }
}
