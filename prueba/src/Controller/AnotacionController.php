<?php

namespace App\Controller;

use App\Entity\Anotacion;
use App\Entity\Informe;
use App\Entity\Campo;
use App\Form\AnotacionType;
use App\Repository\AnotacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/anotacion")
 */
class AnotacionController extends AbstractController
{
    /**
     * @Route("/", name="anotacion_index", methods={"GET"})
     */
    public function index(AnotacionRepository $anotacionRepository): Response
    {
        return $this->render('anotacion/index.html.twig', [
            'anotacions' => $anotacionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="anotacion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $anotacion = new Anotacion();
        $form = $this->createForm(AnotacionType::class, $anotacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($anotacion);
            $entityManager->flush();

            return $this->redirectToRoute('anotacion_index');
        }

        return $this->render('anotacion/new.html.twig', [
            'anotacion' => $anotacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="anotacion_show", methods={"GET"})
     */
    public function show(Anotacion $anotacion): Response
    {
        return $this->render('anotacion/show.html.twig', [
            'anotacion' => $anotacion,
        ]);
    }

    /**
     * @Route("/edit/{informe}-{campo}", name="anotacion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Informe $informe, Campo $campo): Response
    {
        $em = $this->getDoctrine()->getManager();
        $anotacion = $em->getRepository('App:Anotacion')->findOneBy(['informe' => $informe, 'campo' => $campo]);
        
        if (is_null($anotacion)){
            $anotacion = new Anotacion();
            $anotacion->setInforme($informe);
            $anotacion->setCampo($campo);
            $em->persist($anotacion);
            $em->flush();
        }
        error_log($anotacion->getId());
        
        $form = $this->createForm(AnotacionType::class, $anotacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            //return $this->redirectToRoute('anotacion_index');
        }
        

        return $this->render('anotacion/edit.html.twig', [
            'anotacion' => $anotacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="anotacion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Anotacion $anotacion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anotacion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($anotacion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('anotacion_index');
    }
}
