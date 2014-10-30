<?php

namespace fascli\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use fascli\MainBundle\Entity\client;
use fascli\MainBundle\Repository\clientRepository;
use fascli\MainBundle\Form\clientType;
use fascli\MainBundle\Form\ClientRechercheForm;
use FOS\UserBundle\FOSUserBundle;

/**
 * client controller.
 *
 * @Route("/client")
 */
class clientController extends Controller
{
     
     public function bjrmailAction()
 {
   $message = \Swift_Message::newInstance('hp144.hostpapa.com', 465, 'ssl')
        ->setSubject('Fastel Group: Information importante')
        ->setFrom('info@fastel-group.net')
        ->setTo('test@fastel-group.net')
        ->setBody($this->renderView('fascliBdcBundle:Default:emails-infos.html.twig'),'text/html');
        //->setBody('<h1>Here is the message itself, 
        //$this->get('security.context')->getToken()->getUser()->getNom()</h1>', 'text/html');
        //->addPart('<q>Here is the message itself</q>', 'text/html');
        $this->get('mailer')->send($message);
 }   

    /**
     * Lists all client entities.
     *
     * @Route("/", name="client")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
         //$fmt = new \NumberFormatter('fr_FR', NumberFormatter::SPELLOUT);
         //var_dump($fmt->format(2152));
         $em = $this->getDoctrine()->getManager();
         $entities = $em->getRepository('fascliMainBundle:client')->findAll();
         $ent = $em->getRepository('fascliMainBundle:client')->getClientAvecoperations();
        // foreach($ent as $art)
 // {
    // Ne déclenche pas de requête : les commentaires sont déjà chargés !
    // Vous pourriez faire une boucle dessus pour les afficher tous
    //$art->getOperation();
  //}
         //var_dump($ent);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $ent,
        $this->get('request')->query->get('page', 1)/*page number*/,
        5/*limit per page*/
        );
        $this->bjrmailAction();
        return array(
           // 'entities' => $entities,
            'pagination' => $pagination,
        );
    }
    /**
     * Creates a new client entity.
     *
     * @Route("/", name="client_create")
     * @Method("POST")
     * @Template("fascliMainBundle:client:new.html.twig")
     */
    public function createAction(Request $request)
    {
       $entity = new client();
       
      //var_dump(extract($_POST));
      // $nom = $_POST["nom"];
      // $prenoms = $_POST["prenoms"];
     //  var_dump('$_POST['nom'] $_POST['prenoms']' );
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
           $nom = $entity->getNom();
           $prenoms = $entity->getPrenoms();
           $nomprenoms = "$nom  $prenoms";
           $nom1 = $this->get('security.context')->getToken()->getUser()->getNom();
           $prenoms1 = $this->get('security.context')->getToken()->getUser()->getPrenoms();
           $caissier = "$nom1 $prenoms1";
           $cashpoint = $this->get('security.context')->getToken()->getUser()->getCashPoint();
           $entity->setNomPrenoms($nomprenoms);
           $entity->setCaissier($caissier);
           $entity->setCashPoint($cashpoint);
           $em = $this->getDoctrine()->getManager();
           $em->persist($entity);
           $presenceclient = $em->getRepository('fascliMainBundle:client')->RechercheClient($nomprenoms);
           if($presenceclient  !='null'){
            
                $this->get('session')->getFlashBag()->add('noticeClientEnregistre','Client déjà enregistré');
                return $this->redirect($this->generateUrl('client_new'));
            } else if($presenceclient =='null'){
             $em->flush();
            $this->get('session')->getFlashBag()->add('noticeClientBienEnregistre','Félicitations, Client bien enregistré');
            return $this->redirect($this->generateUrl('client_show', array('id' => $entity->getId())));
        } 
                   
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a client entity.
    *
    * @param client $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(client $entity)
    {
        $form = $this->createForm(new clientType(), $entity, array(
            'action' => $this->generateUrl('client_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer'));

        return $form;
    }

    /**
     * Displays a form to create a new client entity.
     *
     * @Route("/new", name="client_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new client();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a client entity.
     *
     * @Route("/{id}", name="client_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:client')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find client entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing client entity.
     *
     * @Route("/{id}/edit", name="client_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:client')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find client entity.');
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
    * Creates a form to edit a client entity.
    *
    * @param client $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(client $entity)
    {
        $form = $this->createForm(new clientType(), $entity, array(
            'action' => $this->generateUrl('client_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing client entity.
     *
     * @Route("/{id}", name="client_update")
     * @Method("PUT")
     * @Template("fascliMainBundle:client:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:client')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find client entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice10','Client mis à jour');
            return $this->redirect($this->generateUrl('client_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a client entity.
     *
     * @Route("/{id}", name="client_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliMainBundle:client')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find client entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('client'));
    }

    /**
     * Creates a form to delete a client entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

     /**
     * Displays a form to list existing Clients.
     *
     * @Route("/client/lister", name="client_lister")
     * @Template()
     */
    public function listerAction()
    {
        $em = $this->container->get('doctrine')->getManager();
        $clients = $em->getRepository('fascliMainBundle:client')->derniersClients(0);;
        $sss = $em->getRepository('fascliMainBundle:client')->findAll();
        $form = $this->createForm(new clientRechercheForm());
    return $this->container->get('templating')->renderResponse('fascliMainBundle:client:lister.html.twig', array(
    'clients' => $clients,
    'sss' => $sss,
    'form' => $form->createView()
));
    }


    /**
     * Displays a form to search existing Clients.
     *
     * @Route("/client/rechercher", name="fas_client_rechercher")
     * @Template()
     */
    public function rechercherAction()
    {
        // ...
    $request = $this->container->get('request');
    if($request->isXmlHttpRequest())
   {
     $motcle = '';
     $motcle = $request->request->get('motcle');
     $em = $this->container->get('doctrine')->getManager();
     if($motcle != '')
      {
       $qb = $em->createQueryBuilder();

       $qb->select('a')
       ->from('fascliMainBundle:client', 'a')
       ->where("a.nom LIKE :motcle OR a.prenoms LIKE :motcle")
       ->orderBy('a.nom', 'ASC')
       ->setParameter('motcle', '%'.$motcle.'%');
       $query = $qb->getQuery();
       $clients = $query->getResult();

     }
     else {
      $clients = $em->getRepository('fascliMainBundle:client')->findAll();
     }
      return $this->container->get('templating')->renderResponse('fascliMainBundle:client:liste.html.twig', array(
      'clients' => $clients
     )); }
     else {
          return $this->listerAction();
    }
 }
}
