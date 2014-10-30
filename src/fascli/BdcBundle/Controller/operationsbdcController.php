<?php

namespace fascli\BdcBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use fascli\BdcBundle\Entity\operationsbdc;
use fascli\BdcBundle\Entity\euro;
use fascli\BdcBundle\Entity\dollar;
use fascli\BdcBundle\Entity\gbp;
use fascli\BdcBundle\Entity\suisse;
use fascli\BdcBundle\Form\operationsbdcType;
use fascli\BdcBundle\Form\operationsdollarType;
use fascli\BdcBundle\Form\operationseuroType;
use fascli\BdcBundle\Form\operationsgbpType;
use fascli\BdcBundle\Form\operationssuisseType;
use Ps\PdfBundle\Annotation\Pdf;
use Symfony\Component\HttpFoundation\Response;

/**
 * operationsbdc controller.
 *
 * @Route("/ope-bdc")
 */
class operationsbdcController extends Controller
{

   /**
 * @Route ("/pdf", name="pdf")
 * @Pdf()
 */
 public function generateAction()
 {

    $facade = $this->get('ps_pdf.facade');
    $response = new Response();
    $em = $this->getDoctrine()->getManager();
    $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->findAll();
    $eee = $em->getRepository('fascliBdcBundle:operationsbdc')->eee();
    var_dump($eee);
    $this->render('fascliMainBundle:Default:generateAction.pdf.twig', array("entity" => $entity), $response);

    $xml = $response->getContent();

    $content = $facade->render($xml);

    return new Response($content, 200, array('content-type' => 'application/pdf'));
}

    /**
     * Lists all operationsbdc entities.
     *
     * @Route("/", name="ope-bdc")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('fascliBdcBundle:operationsbdc')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    private function calculIndiceTaux($val){
        $indice='0';
        if($val=='1'){$indice='1';}
       if($val=='5'){$indice='2';}
       if($val=='10'){$indice='3';}
       if($val=='20'){$indice='4';}
       if($val=='50'){$indice='5';}
       if($val=='100'){$indice='6';}
       if($val=='500'){$indice='7';}
       if($val=='1000'){$indice='8';}
       return $indice;
    }
    /**
     * Creates a new euro operationsbdc entity.
     *
     * @Route("/createeuro", name="createeuro")
     * @Method("POST")
     * @Template("fascliBdcBundle:operationsbdc:neweuro.html.twig")
     */
    public function createeuroAction(Request $request)
    {
        $session = $this->get('session');
        $ope = $session->get('xx');
        $emm = $this->getDoctrine()->getManager();
        $devise= $emm->getRepository('fascliBdcBundle:taux')->trouveDevise($ope);
        $type= $emm->getRepository('fascliBdcBundle:taux')->trouveType($ope);
        
        $entity = new operationsbdc();
        $form = $this->createeuroCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
           
           $entity->setDatope(new \Datetime('now'));
           $nom1 = $this->get('security.context')->getToken()->getUser()->getNom();
           $prenoms1 = $this->get('security.context')->getToken()->getUser()->getPrenoms();
           $caissier = "$nom1 $prenoms1";
           $cashpoint = $this->get('security.context')->getToken()->getUser()->getCashPoint();
           $entity->setCaissier($caissier);
           $entity->setAgence($cashpoint);
           $entity->setDevise($devise);    
           $entity->setTypope($type);
          foreach ($entity->getEuros() as $eur ) {
              $typ = ($type=='ACHAT')?'A':'V';              
              $val = $eur->getVal();
              $indice = $this->calculIndiceTaux($val);
              $taux = $emm->getRepository('fascliBdcBundle:taux')->trouveTaux($indice,$ope);
              $eur->setType($typ);
              $eur->setTaux($taux);
              $remise = $eur->getRemise();
              $tr = $taux - $remise;
              $eur->setTauxreel($tr);
              $eur->setQterest(($eur->getQte())*($eur->getVal()));
              $eur->setMarge('0');
          }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('euroshow', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new dollar operationsbdc entity.
     *
     * @Route("/createdollar", name="createdollar")
     * @Method("POST")
     * @Template("fascliBdcBundle:operationsbdc:newdollar.html.twig")
     */
    public function createdollarAction(Request $request)
    {
       $session = $this->get('session');
        $ope = $session->get('xx');
        $emm = $this->getDoctrine()->getManager();
        $devise= $emm->getRepository('fascliBdcBundle:taux')->trouveDevise($ope);
        $type= $emm->getRepository('fascliBdcBundle:taux')->trouveType($ope);
        
        $entity = new operationsbdc();
        $form = $this->createdollarCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
           
           $entity->setDatope(new \Datetime('now'));
           $nom1 = $this->get('security.context')->getToken()->getUser()->getNom();
           $prenoms1 = $this->get('security.context')->getToken()->getUser()->getPrenoms();
           $caissier = "$nom1 $prenoms1";
           $cashpoint = $this->get('security.context')->getToken()->getUser()->getCashPoint();
           $entity->setCaissier($caissier);
           $entity->setAgence($cashpoint);
           $entity->setDevise($devise);    
           $entity->setTypope($type);
          foreach ($entity->getDollars() as $dol ) {
              $typ = ($type=='ACHAT')?'A':'V';              
              $val = $dol->getVal();
              $indice = $this->calculIndiceTaux($val);
              $taux = $emm->getRepository('fascliBdcBundle:taux')->trouveTaux($indice,$ope);
              $dol->setType($typ);
              $dol->setTaux($taux);
              $remise = $dol->getRemise();
              $tr = $taux - $remise;
              $dol->setTauxreel($tr);
              $dol->setQterest(($dol->getQte())*($dol->getVal()));
              $dol->setMarge('0');
          }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('dollarshow', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new gbp operationsbdc entity.
     *
     * @Route("/creategbp", name="creategbp")
     * @Method("POST")
     * @Template("fascliBdcBundle:operationsbdc:newgbp.html.twig")
     */
    public function creategbpAction(Request $request)
    {
        $session = $this->get('session');
        $ope = $session->get('xx');
        $emm = $this->getDoctrine()->getManager();
        $devise= $emm->getRepository('fascliBdcBundle:taux')->trouveDevise($ope);
        $type= $emm->getRepository('fascliBdcBundle:taux')->trouveType($ope);
        var_dump($type);
        $entity = new operationsbdc();
        $form = $this->creategbpCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
           
           $entity->setDatope(new \Datetime('now'));
           $nom1 = $this->get('security.context')->getToken()->getUser()->getNom();
           $prenoms1 = $this->get('security.context')->getToken()->getUser()->getPrenoms();
           $caissier = "$nom1 $prenoms1";
           $cashpoint = $this->get('security.context')->getToken()->getUser()->getCashPoint();
           $entity->setCaissier($caissier);
           $entity->setAgence($cashpoint);
           $entity->setDevise($devise);    
           $entity->setTypope($type);
          foreach ($entity->getGbps() as $gbp ) {
              $typ = ($type=='ACHAT')?'A':'V';              
              $val = $gbp->getVal();
              $indice = $this->calculIndiceTaux($val);
              $taux = $emm->getRepository('fascliBdcBundle:taux')->trouveTaux($indice,$ope);
              $gbp->setType($typ);
              $gbp->setTaux($taux);
              $remise = $gbp->getRemise();
              $tr = $taux - $remise;
              $gbp->setTauxreel($tr);
              $gbp->setQterest(($gbp->getQte())*($gbp->getVal()));
              $gbp->setMarge('0');
          }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('gbpshow', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new suisse operationsbdc entity.
     *
     * @Route("/createsuisse", name="createsuisse")
     * @Method("POST")
     * @Template("fascliBdcBundle:operationsbdc:newsuisse.html.twig")
     */
    public function createsuisseAction(Request $request)
    {
        $session = $this->get('session');
        $ope = $session->get('xx');
        $emm = $this->getDoctrine()->getManager();
        $devise= $emm->getRepository('fascliBdcBundle:taux')->trouveDevise($ope);
        $type= $emm->getRepository('fascliBdcBundle:taux')->trouveType($ope);
        $entity = new operationsbdc();
        $form = $this->createsuisseCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
           
           $entity->setDatope(new \Datetime('now'));
           $nom1 = $this->get('security.context')->getToken()->getUser()->getNom();
           $prenoms1 = $this->get('security.context')->getToken()->getUser()->getPrenoms();
           $caissier = "$nom1 $prenoms1";
           $cashpoint = $this->get('security.context')->getToken()->getUser()->getCashPoint();
           $entity->setCaissier($caissier);
           $entity->setAgence($cashpoint);
           $entity->setDevise($devise);    
           $entity->setTypope($type);
          foreach ($entity->getSuisses() as $sui ) {
              $typ = ($type=='ACHAT')?'A':'V';              
              $val = $sui->getVal();
              $indice = $this->calculIndiceTaux($val);
              $taux = $emm->getRepository('fascliBdcBundle:taux')->trouveTaux($indice,$ope);
              $sui->setType($typ);
              $sui->setTaux($taux);
              $remise = $sui->getRemise();
              $tr = $taux - $remise;
              $sui->setTauxreel($tr);
              $sui->setQterest(($sui->getQte())*($sui->getVal()));
              $sui->setMarge('0');
          }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('suisseshow', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new operationsbdc entity.
     *
     * @Route("/", name="ope-bdc_create")
     * @Method("POST")
     * @Template("fascliBdcBundle:operationsbdc:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new operationsbdc();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ope-bdc_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a euro operationsbdc entity.
    *
    * @param operationsbdc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createeuroCreateForm(operationsbdc $entity)
    {
        $form = $this->createForm(new operationseuroType(), $entity, array(
            'action' => $this->generateUrl('createeuro'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'ENREGISTRER OPERATION EURO'));

        return $form;
    }

    /**
    * Creates a form to create a dollar operationsbdc entity.
    *
    * @param operationsbdc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createdollarCreateForm(operationsbdc $entity)
    {
        $form = $this->createForm(new operationsdollarType(), $entity, array(
            'action' => $this->generateUrl('createdollar'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'ENREGISTRER OPERATION DOLLAR'));

        return $form;
    }

    /**
    * Creates a form to create a gbp operationsbdc entity.
    *
    * @param operationsbdc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function creategbpCreateForm(operationsbdc $entity)
    {
        $form = $this->createForm(new operationsgbpType(), $entity, array(
            'action' => $this->generateUrl('creategbp'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'ENREGISTRER OPERATION GBP'));

        return $form;
    }

    /**
    * Creates a form to create a suisse operationsbdc entity.
    *
    * @param operationsbdc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createsuisseCreateForm(operationsbdc $entity)
    {
        $form = $this->createForm(new operationssuisseType(), $entity, array(
            'action' => $this->generateUrl('createsuisse'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'ENREGISTRER OPERATION SUISSE'));

        return $form;
    }

    /**
    * Creates a form to create a operationsbdc entity.
    *
    * @param operationsbdc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(operationsbdc $entity)
    {
        $form = $this->createForm(new operationsbdcType(), $entity, array(
            'action' => $this->generateUrl('ope-bdc_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to create a new operationsbdc entity.
     *
     * @Route("/new", name="ope-bdc_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new operationsbdc();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new euro operationsbdc entity.
     *
     * @Route("/neweuro/{type}", name="neweuro")
     * @Method("GET")
     * @Template()
     */
    public function neweuroAction($type)
    {
        $session = $this->get('session');
        $session->set('xx',$type);
        $xx = $session->get('xx');
        $entity = new operationsbdc();
        $form   = $this->createeuroCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            
        );
    }

    /**
     * Displays a form to create a new dollar operationsbdc entity.
     *
     * @Route("/newdollar/{type}", name="newdollar")
     * @Method("GET")
     * @Template()
     */
    public function newdollarAction($type)
    {
        $session = $this->get('session');
        $session->set('xx',$type);
        $xx = $session->get('xx');
        $entity = new operationsbdc();
        $form   = $this->createdollarCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new gbp operationsbdc entity.
     *
     * @Route("/newgbp/{type}", name="newgbp")
     * @Method("GET")
     * @Template()
     */
    public function newgbpAction($type)
    {
        $session = $this->get('session');
        $session->set('xx',$type);
        $xx = $session->get('xx');
        $entity = new operationsbdc();
        $form   = $this->creategbpCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new suisse operationsbdc entity.
     *
     * @Route("/newsuisse/{type}", name="newsuisse")
     * @Method("GET")
     * @Template()
     */
    public function newsuisseAction($type)
    {
        $session = $this->get('session');
        $session->set('xx',$type);
        $xx = $session->get('xx');
        $entity = new operationsbdc();
        $form   = $this->createsuisseCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a operationsbdc entity.
     *
     * @Route("/{id}", name="ope-bdc_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a euro operationsbdc entity.
     *
     * @Route("/euro/{id}", name="euroshow")
     * @Method("GET")
     * @Template("fascliBdcBundle:operationsbdc:showeuro.html.twig")
     */
    public function euroshowAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);
        $caissierId = $this->get('security.context')->getToken()->getUser()->getId();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $deleteForm = $this->createDeleteeuroForm($id);

        return array(
            'entity'      => $entity,
            'cid' => $caissierId,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a dollar operationsbdc entity.
     *
     * @Route("/dollar/{id}", name="dollarshow")
     * @Method("GET")
     * @Template("fascliBdcBundle:operationsbdc:showdollar.html.twig")
     */
    public function dollarshowAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);
        $caissierId = $this->get('security.context')->getToken()->getUser()->getId();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $deleteForm = $this->createDeletedollarForm($id);

        return array(
            'entity'      => $entity,
             'cid' => $caissierId,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a gbp operationsbdc entity.
     *
     * @Route("/gbp/{id}", name="gbpshow")
     * @Method("GET")
     * @Template("fascliBdcBundle:operationsbdc:showgbp.html.twig")
     */
    public function gbpshowAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);
        $caissierId = $this->get('security.context')->getToken()->getUser()->getId();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $deleteForm = $this->createDeletegbpForm($id);

        return array(
            'entity'      => $entity,
            'cid'      => $caissierId,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a suisse operationsbdc entity.
     *
     * @Route("/suisse/{id}", name="suisseshow")
     * @Method("GET")
     * @Template("fascliBdcBundle:operationsbdc:showsuisse.html.twig")
     */
    public function suisseshowAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);
        $caissierId = $this->get('security.context')->getToken()->getUser()->getId();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $deleteForm = $this->createDeletesuisseForm($id);

        return array(
            'entity'      => $entity,
            'cid'      => $caissierId,
            'delete_form' => $deleteForm->createView(),
        );
    }




    /**
     * Displays a form to edit an euro existing operationsbdc entity.
     *
     * @Route("/{id}/euroedit", name="euroedit")
     * @Method("GET")
     * @Template()
     */
    public function editeuroAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }
        $originalEuros = new ArrayCollection();
        foreach ($entity->getEuros() as $euro) {
        $originalEuros->add($euro);
        }
        $editForm = $this->createEditeuroForm($entity);
        $deleteForm = $this->createDeleteeuroForm($id);

        return array(
            'entity'      => $entity,
            'originalEuros' => $originalEuros,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an dollar existing operationsbdc entity.
     *
     * @Route("/dollar/{id}/edit", name="ope-bdc_editdollar")
     * @Method("GET")
     * @Template()
     */
    public function editdollarAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $editForm = $this->createEditdollarForm($entity);
        $deleteForm = $this->createDeletedollarForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an gbp existing operationsbdc entity.
     *
     * @Route("/gbp/{id}/edit", name="ope-bdc_editgbp")
     * @Method("GET")
     * @Template()
     */
    public function editgbpAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $editForm = $this->createEditgbpForm($entity);
        $deleteForm = $this->createDeletegbpForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an suisse existing operationsbdc entity.
     *
     * @Route("/suisse/{id}/edit", name="ope-bdc_editsuisse")
     * @Method("GET")
     * @Template()
     */
    public function editsuisseAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $editForm = $this->createEditsuisseForm($entity);
        $deleteForm = $this->createDeletesuisseForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing operationsbdc entity.
     *
     * @Route("/{id}/edit", name="ope-bdc_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a euro operationsbdc entity.
    *
    * @param operationsbdc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditeuroForm(operationsbdc $entity)
    {
        $form = $this->createForm(new operationseuroType(), $entity, array(
            'action' => $this->generateUrl('euroupdate', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Updateeuro'));

        return $form;
    }

    /**
    * Creates a form to edit a dollar operationsbdc entity.
    *
    * @param operationsbdc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditdollarForm(operationsbdc $entity)
    {
        $form = $this->createdollarForm(new operationsdollarType(), $entity, array(
            'action' => $this->generateUrl('dollarupdate', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Updatedollar'));

        return $form;
    }

    /**
    * Creates a form to edit a gbp operationsbdc entity.
    *
    * @param operationsbdc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditgbpForm(operationsbdc $entity)
    {
        $form = $this->createForm(new operationsgbpType(), $entity, array(
            'action' => $this->generateUrl('gbpupdate', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Updategbp'));

        return $form;
    }

    /**
    * Creates a form to edit a suisse operationsbdc entity.
    *
    * @param operationsbdc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditsuisseForm(operationsbdc $entity)
    {
        $form = $this->createsuisseForm(new operationssuisseType(), $entity, array(
            'action' => $this->generateUrl('suisseupdate', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Updatesuisse'));

        return $form;
    }

    /**
    * Creates a form to edit a operationsbdc entity.
    *
    * @param operationsbdc $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(operationsbdc $entity)
    {
        $form = $this->createForm(new operationsbdcType(), $entity, array(
            'action' => $this->generateUrl('ope-bdc_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing euro operationsbdc entity.
     *
     * @Route("/{id}", name="euroupdate")
     * @Method("PUT")
     * @Template("fascliBdcBundle:operationsbdc:euroedit.html.twig")
     */
    public function updateeuroAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $deleteForm = $this->createDeleteeuroForm($id);
        $editForm = $this->createEditeuroForm($entity);
        $editForm->handleRequest($request);
        $originalEuros = new ArrayCollection();
        foreach ($entity->getEuros() as $euro) {
        $originalEuros->add($euro);
        }
        if ($editForm->isValid()) {

            foreach ($originalEuros as $euro) {
                if ($entity->getEuros()->contains($euro) == false) {
                // supprime la « Task » du Tag
                    $entity->getEuros()->removeElement($euro);

                    // si c'était une relation ManyToOne, vous pourriez supprimer la
                    // relation comme ceci
                    // $tag->setTask(null);

                    $em->persist($euro);

                    // si vous souhaitiez supprimer totalement le Tag, vous pourriez
                    // aussi faire comme cela
                    // $em->remove($tag);
                }
            }
            $em->flush();

            return $this->redirect($this->generateUrl('euroedit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing dollar operationsbdc entity.
     *
     * @Route("/{id}", name="ope-bdc_updatedollar")
     * @Method("PUT")
     * @Template("fascliBdcBundle:operationsbdc:dollaredit.html.twig")
     */
    public function updatedollarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $deleteForm = $this->createDeletedollarForm($id);
        $editForm = $this->createEditdollarForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ope-bdc_editdollar', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing gbp operationsbdc entity.
     *
     * @Route("/{id}", name="ope-bdc_updategbp")
     * @Method("PUT")
     * @Template("fascliBdcBundle:operationsbdc:gbpedit.html.twig")
     */
    public function updategbpAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $deleteForm = $this->createDeletegbpForm($id);
        $editForm = $this->createEditgbpForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ope-bdc_editgbp', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing suisse operationsbdc entity.
     *
     * @Route("/{id}", name="ope-bdc_updatesuisse")
     * @Method("PUT")
     * @Template("fascliBdcBundle:operationsbdc:suisseedit.html.twig")
     */
    public function updatesuisseAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $deleteForm = $this->createDeletesuisseForm($id);
        $editForm = $this->createEditsuisseForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ope-bdc_editsuisse', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing operationsbdc entity.
     *
     * @Route("/{id}", name="ope-bdc_update")
     * @Method("PUT")
     * @Template("fascliBdcBundle:operationsbdc:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operationsbdc entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            
            return $this->redirect($this->generateUrl('ope-bdc_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a euro operationsbdc entity.
     *
     * @Route("/{id}", name="deleteeuro")
     * @Method("DELETE")
     */
    public function deleteeuroAction(Request $request, $id)
    {
        $form = $this->createDeleteeuroForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find operationsbdc entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('choixdevise'));
    }

    /**
     * Deletes a dollar operationsbdc entity.
     *
     * @Route("/{id}", name="deletedollar")
     * @Method("DELETE")
     */
    public function deletedollarAction(Request $request, $id)
    {
        $form = $this->createDeletedollarForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find operationsbdc entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('choixdevise'));
    }

    /**
     * Deletes a gbp operationsbdc entity.
     *
     * @Route("/{id}", name="deletegbp")
     * @Method("DELETE")
     */
    public function deletegbpAction(Request $request, $id)
    {
        $form = $this->createDeletegbpForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find operationsbdc entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('choixdevise'));
    }

    /**
     * Deletes a suisse operationsbdc entity.
     *
     * @Route("/{id}", name="deletesuisse")
     * @Method("DELETE")
     */
    public function deletesuisseAction(Request $request, $id)
    {
        $form = $this->createDeletesuisseForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find operationsbdc entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('choixdevise'));
    }

    /**
     * Deletes a operationsbdc entity.
     *
     * @Route("/{id}", name="ope-bdc_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliBdcBundle:operationsbdc')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find operationsbdc entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ope-bdc'));
    }


    /**
     * Creates a form to delete a euro operationsbdc entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteeuroForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('deleteeuro', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Deleteeuro'))
            ->getForm()
        ;
    }

    /**
     * Creates a form to delete a dollar operationsbdc entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeletedollarForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('deletedollar', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Deletedollar'))
            ->getForm()
        ;
    }

    /**
     * Creates a form to delete a gbp operationsbdc entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeletegbpForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('deletegbp', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Deletegbp'))
            ->getForm()
        ;
    }

    /**
     * Creates a form to delete a suisse operationsbdc entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeletesuisseForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('deletesuisse', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Deletesuisse'))
            ->getForm()
        ;
    }

    /**
     * Creates a form to delete a operationsbdc entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ope-bdc_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'ANNULER',
                                             'attr'=>array('class'=>'btn btn-primary'),))
            ->getForm()
        ;
    }

    
}
