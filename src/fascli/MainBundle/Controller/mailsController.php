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

class mailsController extends Controller
{
	/**
     * @Route("/anniv-client",name="anniv-client")
     * 
     */
	public function annivclientAction()
 {
    $em = $this->getDoctrine()->getManager();
        $clientauj = $em->getRepository('fascliMainBundle:client')->CltsNesAujourdhui();
       // var_dump($clientauj);
        $clientdem = $em->getRepository('fascliMainBundle:client')->CltsNesDemain();
   if($clientauj=='null' && $clientdem=='null'){
     return ;
   }
   $message = \Swift_Message::newInstance('hp144.hostpapa.com', 465, 'ssl')
        ->setSubject('FASTEL GROUP: Anniversaires de nos Clients')
        ->setFrom('info@fastel-group.net')
        ->setTo('raf@fastel-group.net')
        ->setBody($this->renderView('fascliMainBundle:mails:emails-anniversaire-clients.html.twig',
        	                        array('clientauj' => $clientauj,'clientdem' => $clientdem)),'text/html');
        $this->get('mailer')->send($message);
        return ;
 }   
   /**
     * @Route("/annivv-client",name="annivv-client")
     * @Template("fascliMainBundle:mails:emails-anniversaire-clients.html.twig")
     */
    public function annivvclientAction()
    {
    	$em = $this->getDoctrine()->getManager();
        $NesAuj = $em->getRepository('fascliMainBundle:client')->CltsNesAujourdhui();
        $NesDem = $em->getRepository('fascliMainBundle:client')->CltsNesDemain();

        return array();
    }
}
   