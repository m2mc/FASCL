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

class pdfController extends Controller
{
	/**
     * @Route("/essai/{id}",name="essai")
     * @Template("fascliMainBundle:pdf:essai.html.twig")
     */
    public function essaiAction($id)
    {
        $caissierId = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->findById($id);
        $euros = $em->getRepository('fascliBdcBundle:euro')->getLignesForEuros($id);
        $html = $this->renderView('fascliMainBundle:pdf:essai.html.twig',array('entity'=>$entity,'euros'=>$euros,'cid'=>$caissierId));
        $html2pdf = $this->get('html2pdf')->get();
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $fichier = $html2pdf->Output('facture.pdf','I');
        $response = new Response();
		$response->clearHttpHeaders();
		$response->setContent(file_get_contents($fichier));
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-disposition', 'filename='.$fichier);
		return $response;

    }

    /**
     * @Route("/rapporteuro",name="rapporteuro")
     * @Template("fascliMainBundle:pdf:rapporteuro.html.twig")
     */
    public function rapporteurosAction()
    {
        $date = new \Datetime();
        $nom1 = $this->get('security.context')->getToken()->getUser()->getNom();
        $prenoms1 = $this->get('security.context')->getToken()->getUser()->getPrenoms();
        $agence = $this->get('security.context')->getToken()->getUser()->getCashPoint();
        $caissier = "$nom1 $prenoms1";
        $em = $this->getDoctrine()->getManager();
        $achateuros = $em->getRepository('fascliBdcBundle:operationsbdc')->caissierachateuros($caissier);
        $venteeuros = $em->getRepository('fascliBdcBundle:operationsbdc')->caissierventeeuros($caissier);
        $html = $this->renderView('fascliMainBundle:pdf:rapporteuro.html.twig',array('achat'=>$achateuros,
                                                                                     'vente'=>$venteeuros,
                                                                                     'caissier'=>$caissier,
                                                                                     'date'=>$date,
                                                                                    'agence'=>$agence));
        $html2pdf = $this->get('html2pdf')->get();
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $fichier = $html2pdf->Output('facture.pdf','I');
        $response = new Response();
        $response->clearHttpHeaders();
        $response->setContent(file_get_contents($fichier));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-disposition', 'filename='.$fichier);
        return $response;

    }

    /**
     * @Route("/rapportdollar",name="rapportdollar")
     * @Template("fascliMainBundle:pdf:rapportdollar.html.twig")
     */
    public function rapportdollarsAction()
    {
        $date = new \Datetime();
        $nom1 = $this->get('security.context')->getToken()->getUser()->getNom();
        $prenoms1 = $this->get('security.context')->getToken()->getUser()->getPrenoms();
        $agence = $this->get('security.context')->getToken()->getUser()->getCashPoint();
        $caissier = "$nom1 $prenoms1";
        $em = $this->getDoctrine()->getManager();
        $achatdollars = $em->getRepository('fascliBdcBundle:operationsbdc')->caissierachatdollars($caissier);
        $ventedollars = $em->getRepository('fascliBdcBundle:operationsbdc')->caissierventedollars($caissier);
        $html = $this->renderView('fascliMainBundle:pdf:rapportdollar.html.twig',array('achat'=>$achatdollars,
                                                                                     'vente'=>$ventedollars,
                                                                                     'caissier'=>$caissier,
                                                                                     'date'=>$date,
                                                                                    'agence'=>$agence));
        $html2pdf = $this->get('html2pdf')->get();
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $fichier = $html2pdf->Output('facture.pdf','I');
        $response = new Response();
        $response->clearHttpHeaders();
        $response->setContent(file_get_contents($fichier));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-disposition', 'filename='.$fichier);
        return $response;

    }

     /**
     * @Route("/rapportgbp",name="rapportgbp")
     * @Template("fascliMainBundle:pdf:rapportgbp.html.twig")
     */
    public function rapportgbpsAction()
    {
        $date = new \Datetime();
        $nom1 = $this->get('security.context')->getToken()->getUser()->getNom();
        $prenoms1 = $this->get('security.context')->getToken()->getUser()->getPrenoms();
        $agence = $this->get('security.context')->getToken()->getUser()->getCashPoint();
        $caissier = "$nom1 $prenoms1";
        $em = $this->getDoctrine()->getManager();
        $achatgbps = $em->getRepository('fascliBdcBundle:operationsbdc')->caissierachatgbps($caissier);
        $ventegbps = $em->getRepository('fascliBdcBundle:operationsbdc')->caissierventegbps($caissier);
        $html = $this->renderView('fascliMainBundle:pdf:rapportgbp.html.twig',array('achat'=>$achatgbps,
                                                                                     'vente'=>$ventegbps,
                                                                                     'caissier'=>$caissier,
                                                                                     'date'=>$date,
                                                                                    'agence'=>$agence));
        $html2pdf = $this->get('html2pdf')->get();
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $fichier = $html2pdf->Output('facture.pdf','I');
        $response = new Response();
        $response->clearHttpHeaders();
        $response->setContent(file_get_contents($fichier));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-disposition', 'filename='.$fichier);
        return $response;

    }

    /**
     * @Route("/rapportsuisse",name="rapportsuisse")
     * @Template("fascliMainBundle:pdf:rapportsuisse.html.twig")
     */
    public function rapportsuissesAction()
    {
        $date = new \Datetime();
        $nom1 = $this->get('security.context')->getToken()->getUser()->getNom();
        $prenoms1 = $this->get('security.context')->getToken()->getUser()->getPrenoms();
        $agence = $this->get('security.context')->getToken()->getUser()->getCashPoint();
        $caissier = "$nom1 $prenoms1";
        $em = $this->getDoctrine()->getManager();
        $achatsuisses = $em->getRepository('fascliBdcBundle:operationsbdc')->caissierachatsuisses($caissier);
        $ventesuisses = $em->getRepository('fascliBdcBundle:operationsbdc')->caissierventesuisses($caissier);
        $html = $this->renderView('fascliMainBundle:pdf:rapportsuisse.html.twig',array('achat'=>$achatsuisses,
                                                                                     'vente'=>$ventesuisses,
                                                                                     'caissier'=>$caissier,
                                                                                     'date'=>$date,
                                                                                    'agence'=>$agence));
        $html2pdf = $this->get('html2pdf')->get();
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $fichier = $html2pdf->Output('facture.pdf','I');
        $response = new Response();
        $response->clearHttpHeaders();
        $response->setContent(file_get_contents($fichier));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-disposition', 'filename='.$fichier);
        return $response;

    }
    
}
   