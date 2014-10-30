<?php

namespace fascli\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use fascli\MainBundle\Entity\nouvelles;
use fascli\MainBundle\Form\nouvellesType;

/**
 * nouvelles controller.
 *
 * @Route("/nouvelles")
 */
class nouvellesController extends Controller
{
    private function emailsInfosAction()
 {
 /**
     *
     *
     * @Route("/emailsInfos", name="emailsInfos")
     * @Template()
     */
 
   $message = \Swift_Message::newInstance('hp144.hostpapa.com', 465, 'ssl')
        ->setSubject('Fastel Group: Information importante')
        ->setFrom('info@fastel-group.net')
        ->setTo('test@fastel-group.net')
        ->setBody($this->renderView('fascliBdcBundle:Default:emails-infos.html.twig'),'text/html');
        $this->get('mailer')->send($message);
 }   

    /**
     * Lists all nouvelles entities.
     *
     * @Route("/", name="nouvelles")
     * @Method("GET")
     * @Template("fascliMainBundle:Default:app.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('fascliMainBundle:nouvelles')->findAll();
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
     * Creates a new nouvelles entity.
     *
     * @Route("/", name="nouvelles_create")
     * @Method("POST")
     * @Template("fascliMainBundle:nouvelles:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new nouvelles();
        $form = $this->createCreateForm($entity);   
        $form->handleRequest($request);

        if ($form->isValid()) {
            $now = new \DateTime();
            $nom = $this->get('security.context')->getToken()->getUser()->getNom();
            $prenoms = $this->get('security.context')->getToken()->getUser()->getPrenoms();
            $enregistreur = "$nom $prenoms";
            $entity->setDatenr($now);
            $entity->setEnregistreur($enregistreur);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->emailsInfosAction();
            return $this->redirect($this->generateUrl('nouvelles_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a nouvelles entity.
    *
    * @param nouvelles $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(nouvelles $entity)
    {
        $form = $this->createForm(new nouvellesType(), $entity, array(
            'action' => $this->generateUrl('nouvelles_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer'));

        return $form;
    }

    /**
     * Displays a form to create a new nouvelles entity.
     *
     * @Route("/new", name="nouvelles_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new nouvelles();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a nouvelles entity.
     *
     * @Route("/{id}", name="nouvelles_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:nouvelles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find nouvelles entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing nouvelles entity.
     *
     * @Route("/{id}/edit", name="nouvelles_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:nouvelles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find nouvelles entity.');
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
    * Creates a form to edit a nouvelles entity.
    *
    * @param nouvelles $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(nouvelles $entity)
    {
        $form = $this->createForm(new nouvellesType(), $entity, array(
            'action' => $this->generateUrl('nouvelles_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing nouvelles entity.
     *
     * @Route("/{id}", name="nouvelles_update")
     * @Method("PUT")
     * @Template("fascliMainBundle:nouvelles:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:nouvelles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find nouvelles entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
             $this->get('session')->getFlashBag()->add('notice5','Dépense mise à jour');
            return $this->redirect($this->generateUrl('nouvelles_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a nouvelles entity.
     *
     * @Route("/{id}", name="nouvelles_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliMainBundle:nouvelles')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find nouvelles entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('nouvelles'));
    }

    /**
     * Creates a form to delete a nouvelles entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nouvelles_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
