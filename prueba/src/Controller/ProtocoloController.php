<?php

namespace App\Controller;

use App\Entity\Protocolo;
use App\Entity\TipoEquipo;
use App\Entity\EquipoInstalado;
use App\Form\ProtocoloType;
use App\Repository\ProtocoloRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/protocolo")
 */
class ProtocoloController extends AbstractController
{
    /**
     * @Route("/", name="protocolo_index", methods={"GET"})
     */
    public function index(ProtocoloRepository $protocoloRepository): Response
    {
        return $this->render('protocolo/index.html.twig', [
            'protocolos' => $protocoloRepository->findAll(),
        ]);
    }

    private function newProtocolo(TipoEquipo $tipo)
    {
        $protocolo = new Protocolo();
        $protocolo->setTipoEquipo($tipo);
        $em = $this->getDoctrine()->getManager();
        $em->persist($protocolo);
        $em->flush();
        
        return $protocolo;
    }

    /**
     * @Route("/edit/{tipo}", name="protocolo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoEquipo $tipo): Response
    {
        $em = $this->getDoctrine()->getManager();
        
        $protocolo = $em->getRepository('App:Protocolo')->findOneBy(['tipoEquipo' => $tipo->getId()]);
        
        if (is_null($protocolo)) $protocolo = $this->newProtocolo($tipo);

        $form = $this->createForm(ProtocoloType::class, $protocolo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('protocolo_index');
        }

        return $this->render('protocolo/edit.html.twig', [
            'protocolo' => $protocolo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="protocolo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Protocolo $protocolo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$protocolo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($protocolo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('protocolo_index');
    }
   
}
