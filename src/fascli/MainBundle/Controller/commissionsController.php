<?php

namespace fascli\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use fascli\MainBundle\Entity\commissions;
use fascli\MainBundle\Form\commissionsType;

/**
 * commissions controller.
 *
 * @Route("/com")
 */
class commissionsController extends Controller
{

    /**
     * Lists all commissions entities.
     *
     * @Route("/", name="com")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('fascliMainBundle:commissions')->toutcommissions();
        $comMois = $em->getRepository('fascliMainBundle:commissions')->comMois();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $comMois,
        $this->get('request')->query->get('page', 1)/*page number*/,
        5/*limit per page*/
        );
        return array(
            'entities' => $entities,
            'pagination' => $pagination,
            'comMois' => $comMois,
        );
    }
    /**
     * Creates a new commissions entity.
     *
     * @Route("/", name="com_create")
     * @Method("POST")
     * @Template("fascliMainBundle:commissions:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new commissions();
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

            return $this->redirect($this->generateUrl('com_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a commissions entity.
    *
    * @param commissions $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(commissions $entity)
    {
        $form = $this->createForm(new commissionsType(), $entity, array(
            'action' => $this->generateUrl('com_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer'));

        return $form;
    }

    /**
     * Displays a form to create a new commissions entity.
     *
     * @Route("/new", name="com_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new commissions();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a commissions entity.
     *
     * @Route("/{id}", name="com_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:commissions')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find commissions entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing commissions entity.
     *
     * @Route("/{id}/edit", name="com_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:commissions')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find commissions entity.');
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
    * Creates a form to edit a commissions entity.
    *
    * @param commissions $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(commissions $entity)
    {
        $form = $this->createForm(new commissionsType(), $entity, array(
            'action' => $this->generateUrl('com_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing commissions entity.
     *
     * @Route("/{id}", name="com_update")
     * @Method("PUT")
     * @Template("fascliMainBundle:commissions:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:commissions')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find commissions entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice2','Enregistrement mis à jour');
            return $this->redirect($this->generateUrl('com_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a commissions entity.
     *
     * @Route("/{id}", name="com_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliMainBundle:commissions')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find commissions entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com'));
    }

    /**
     * Creates a form to delete a commissions entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
