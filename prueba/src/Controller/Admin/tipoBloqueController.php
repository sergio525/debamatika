<?php

namespace App\Controller\Admin;

use App\Entity\Admin\tipoBloque;
use App\Form\Admin\tipoBloqueType;
use App\Repository\Admin\tipoBloqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tipo-bloque")
 */
class tipoBloqueController extends AbstractController
{
    /**
     * @Route("/select", name="admin_tipo_bloque_select", methods={"GET"})
     */
    public function select(tipoBloqueRepository $tipoBloqueRepository): Response
    {
        return $this->render('admin/tipo_bloque/index.html.twig', [
            'tipo_bloques' => $tipoBloqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_tipo_bloque_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipoBloque = new tipoBloque();
        $form = $this->createForm(tipoBloqueType::class, $tipoBloque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipoBloque);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tipo_bloque_index');
        }

        return $this->render('admin/tipo_bloque/new.html.twig', [
            'tipo_bloque' => $tipoBloque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tipo_bloque_show", methods={"GET"})
     */
    public function show(tipoBloque $tipoBloque): Response
    {
        return $this->render('admin/tipo_bloque/show.html.twig', [
            'tipo_bloque' => $tipoBloque,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_tipo_bloque_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, tipoBloque $tipoBloque): Response
    {
        $form = $this->createForm(tipoBloqueType::class, $tipoBloque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tipo_bloque_index');
        }

        return $this->render('admin/tipo_bloque/edit.html.twig', [
            'tipo_bloque' => $tipoBloque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tipo_bloque_delete", methods={"DELETE"})
     */
    public function delete(Request $request, tipoBloque $tipoBloque): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoBloque->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tipoBloque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tipo_bloque_index');
    }
}
