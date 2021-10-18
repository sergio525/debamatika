<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="default_index", methods={"GET"})
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        
        $informes = $em->getRepository('App:Informe')->findBy(['estado' => 'proceso']);
        
        $clientes = [];
        
        foreach ($informes as $informe){
            $cliente = $informe->getEquipo()->getInstalacion()->getCliente()->getRazonSocial();
            
            $clientes[] = $cliente;
        }
        
        $clientes = array_unique($clientes);
        asort($clientes);
        return $this->render('dashboard.html.twig',[
            'clientes' => $clientes,
            'informes' => $informes,
        ]);
    }

}
