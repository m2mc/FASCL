<?php

namespace fascli\MainBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ps\PdfBundle\Annotation\Pdf;
use fascli\BdcBundle\Entity\operationsbdc;
use fascli\BdcBundle\Repository\operationsbdcRepository;

class DefaultController extends Controller
{
   
    /**
     * @Route("/",name="page")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/app",name="app")
     * @Template("fascliMainBundle:Default:app.html.twig")
     */
    public function appAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('fascliMainBundle:nouvelles')->toutnouvelles();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $entities,
        $this->get('request')->query->get('page', 1)/*page number*/,
        5/*limit per page*/
        );
        return array(
            'entities' => $entities,
            'pagination' => $pagination,
        );
    }

    /**
     * @Route("/reglements-lois",name="reg")
     * @Template("fascliMainBundle:Default:reg.html.twig")
     */
    public function regAction()
    {
        return array();
    }


}