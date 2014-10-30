<?php

namespace fascli\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use fascli\MainBundle\Entity\memos;
use fascli\MainBundle\Form\memosType;

/**
 * memos controller.
 *
 * @Route("/memos")
 */
class memosController extends Controller
{

    /**
     * Lists all memos entities.
     *
     * @Route("/", name="memos")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('fascliMainBundle:memos')->toutmemos();

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
     * Creates a new memos entity.
     *
     * @Route("/", name="memos_create")
     * @Method("POST")
     * @Template("fascliMainBundle:memos:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new memos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $now = new \DateTime();
            $nom = $this->get('security.context')->getToken()->getUser()->getNom();
            $prenoms = $this->get('security.context')->getToken()->getUser()->getPrenoms();
            $enregistreur = "$nom $prenoms";
            $entity->setDatenr($now);
            $entity->setDe($enregistreur);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('memos_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a memos entity.
    *
    * @param memos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(memos $entity)
    {
        $form = $this->createForm(new memosType(), $entity, array(
            'action' => $this->generateUrl('memos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer'));

        return $form;
    }

    /**
     * Displays a form to create a new memos entity.
     *
     * @Route("/new", name="memos_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new memos();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a memos entity.
     *
     * @Route("/{id}", name="memos_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:memos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find memos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing memos entity.
     *
     * @Route("/{id}/edit", name="memos_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:memos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find memos entity.');
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
    * Creates a form to edit a memos entity.
    *
    * @param memos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(memos $entity)
    {
        $form = $this->createForm(new memosType(), $entity, array(
            'action' => $this->generateUrl('memos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing memos entity.
     *
     * @Route("/{id}", name="memos_update")
     * @Method("PUT")
     * @Template("fascliMainBundle:memos:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliMainBundle:memos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find memos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
             $this->get('session')->getFlashBag()->add('notice4','Dépense mise à jour');
            return $this->redirect($this->generateUrl('memos_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a memos entity.
     *
     * @Route("/{id}", name="memos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliMainBundle:memos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find memos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('memos'));
    }

    /**
     * Creates a form to delete a memos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('memos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
