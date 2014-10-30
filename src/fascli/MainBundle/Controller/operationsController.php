<?php

namespace fascli\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use fascli\MainBundle\Entity\operations;
use fascli\MainBundle\Form\operationsType;
use fascli\UserBundle\Repository\UserRepository;

/**
 * operations controller.
 *
 * @Route("/ope")
 */
class operationsController extends Controller
{


/**
     * @Route("/json",name="json")
     * @Template("fascliMainBundle:operations:mnew.html.twig")
     */
    public function jsonAction(Request $request)
    {
       $request = $this->get('request');
 
        if($request->isXmlHttpRequest())
        {
            $term = $request->request->get('nomprenoms');
            $array= $this->getDoctrine()
            ->getEntityManager()
            ->getRepository('fascliMainBundle:client')
            ->findnomsLike($term);
            $response = new Response(json_encode($array));
            $response -> headers -> set('Content-Type', 'application/json');
            return $response;
        }
    }   


    /**
     * Lists all operations entities.
     *
     * @Route("/", name="ope")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nom = $this->get('security.context')->getToken()->getUser()->getNom();
        $prenoms = $this->get('security.context')->getToken()->getUser()->getPrenoms();
        $caissier = "$nom $prenoms";
        $entities = $em->getRepository('fascliMainBundle:operations')->AllUserOperat($caissier); 
        $envois = $em->getRepository('fascliMainBundle:operations')->AllUserEnvois($caissier); 
        $paiements = $em->getRepository('fascliMainBundle:operations')->AllUserPaiements($caissier); 
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $entities,
        $this->get('request')->query->get('page', 1)/*page number*/,
        5/*limit per page*/
        );
        return array(
            'entities' => $entities,
            'envois' => $envois,
            'paiements' => $paiements,
            'pagination' => $pagination,
        );
    }
    /**
     * Creates a new operations entity.
     *
     * @Route("/", name="ope_create")
     * @Method("POST")
     * @Template("fascliMainBundle:operations:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new operations();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $now = new \DateTime();
            $nom = $this->get('security.context')->getToken()->getUser()->getNom();
           $prenoms = $this->get('security.context')->getToken()->getUser()->getPrenoms();
           $caissier = "$nom $prenoms";
           $cashpoint = $this->get('security.context')->getToken()->getUser()->getCashPoint();
           $entity->setDatope($now);
            $entity->setCaissier($caissier);
           $entity->setCashPoint($cashpoint);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('ope_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a operations entity.
    *
    * @param operations $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(operations $entity)
    {
        $form = $this->createForm(new operationsType(), $entity, array(
            'action' => $this->generateUrl('ope_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer'));

        return $form;
    }

    /**
     * Displays a form to create a new operations entity.
     *
     * @Route("/new", name="ope_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new operations();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a operations entity.
     *
     * @Route("/{id}", name="ope_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:operations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operations entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing operations entity.
     *
     * @Route("/{id}/edit", name="ope_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:operations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operations entity.');
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
    * Creates a form to edit a operations entity.
    *
    * @param operations $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(operations $entity)
    {
        $form = $this->createForm(new operationsType(), $entity, array(
            'action' => $this->generateUrl('ope_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing operations entity.
     *
     * @Route("/{id}", name="ope_update")
     * @Method("PUT")
     * @Template("fascliMainBundle:operations:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:operations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find operations entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice6','Opération mise à jour');
            return $this->redirect($this->generateUrl('ope_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a operations entity.
     *
     * @Route("/{id}", name="ope_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliMainBundle:operations')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find operations entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ope'));
    }

    /**
     * Creates a form to delete a operations entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ope_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
