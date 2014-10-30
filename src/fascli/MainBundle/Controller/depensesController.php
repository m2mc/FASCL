<?php

namespace fascli\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use fascli\MainBundle\Entity\depenses;
use fascli\MainBundle\Form\depensesType;

/**
 * depenses controller.
 *
 * @Route("/dep")
 */
class depensesController extends Controller
{

    /**
     * Lists all depenses entities.
     *
     * @Route("/", name="dep")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('fascliMainBundle:depenses')->toutdepenses();
        $entitiesmois = $em->getRepository('fascliMainBundle:depenses')->depensesMois();
       $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $entitiesmois,
        $this->get('request')->query->get('page', 1)/*page number*/,
        5/*limit per page*/
        );
        return array(
            'entities' => $entities,
            'pagination' => $pagination,
            'entitiesmois' => $entitiesmois,
        );
    }
    /**
     * Creates a new depenses entity.
     *
     * @Route("/", name="dep_create")
     * @Method("POST")
     * @Template("fascliMainBundle:depenses:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new depenses();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $nom = $this->get('security.context')->getToken()->getUser()->getNom();
            $prenoms = $this->get('security.context')->getToken()->getUser()->getPrenoms();
            $enregistreur = "$nom $prenoms";
            $entity->setEnregistreur($enregistreur);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dep_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a depenses entity.
    *
    * @param depenses $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(depenses $entity)
    {
        $form = $this->createForm(new depensesType(), $entity, array(
            'action' => $this->generateUrl('dep_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer'));

        return $form;
    }

    /**
     * Displays a form to create a new depenses entity.
     *
     * @Route("/new", name="dep_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new depenses();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a depenses entity.
     *
     * @Route("/{id}", name="dep_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:depenses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find depenses entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing depenses entity.
     *
     * @Route("/{id}/edit", name="dep_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:depenses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find depenses entity.');
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
    * Creates a form to edit a depenses entity.
    *
    * @param depenses $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(depenses $entity)
    {
        $form = $this->createForm(new depensesType(), $entity, array(
            'action' => $this->generateUrl('dep_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing depenses entity.
     *
     * @Route("/{id}", name="dep_update")
     * @Method("PUT")
     * @Template("fascliMainBundle:depenses:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:depenses')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find depenses entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice3','Dépense mise à jour');
            return $this->redirect($this->generateUrl('dep_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a depenses entity.
     *
     * @Route("/{id}", name="dep_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliMainBundle:depenses')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find depenses entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dep'));
    }

    /**
     * Creates a form to delete a depenses entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dep_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
}
