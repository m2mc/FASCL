<?php

namespace fascli\BdcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    /**
     * @Route("/choix-devise", name="choixdevise")
     * @Template("fascliBdcBundle:Default:choix-devise.html.twig")
     */

     public function choixdeviseAction()
    {     
        $em = $this->getDoctrine()->getManager();
        
        
        //var_dump($results['0']['type']['id']);
        //var_dump($results);

        //var_dump($results['qterest']);
        return array();
    }

    /**
     * @Route("/tcpdf", name="tcpdf")
     * @Template("fascliBdcBundle:Default:choix-devise.html.twig")
     */

     public function tcpdfAction()
    {        
        $pdf = $container->get("white_october.tcpdf")->create();
        var_dump($pdf);
    }


	 /**
     * @Route("/ope-bdc/euronew/{type}", name="choixope")
     * 
     */

     public function choixachatAction($type)
    {
        
    	if($type=='EA'){
        return $this->redirect($this->generateUrl('euronew', array('type'=>'ACHAT')));
        }
        if($type=='EV'){
        return $this->redirect($this->generateUrl('euronew', array('type'=>'VENTE')));
        }
        if($type=='DA'){
        return $this->redirect($this->generateUrl('euronew', array('type'=>'ACHAT')));
        }
        if($type=='DV'){
        return $this->redirect($this->generateUrl('euronew', array('type'=>'ACHAT')));
        }
        if($type=='GA'){
        return $this->redirect($this->generateUrl('euronew', array('type'=>'ACHAT')));
        }
        if($type=='GV'){
        return $this->redirect($this->generateUrl('euronew', array('type'=>'ACHAT')));
        }
        if($type=='SA'){
        return $this->redirect($this->generateUrl('euronew', array('type'=>'ACHAT')));
        }
        if($type=='SV'){
        return $this->redirect($this->generateUrl('euronew', array('type'=>'ACHAT')));
        }
        
    }
     

    
}
