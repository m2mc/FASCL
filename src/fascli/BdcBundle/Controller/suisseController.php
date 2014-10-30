<?php

namespace fascli\BdcBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use fascli\BdcBundle\Entity\suisse;
use fascli\BdcBundle\Form\suisseType;

/**
 * suisse controller.
 *
 * @Route("/suisse")
 */
class suisseController extends Controller
{

    /**
     * Lists all suisse entities.
     *
     * @Route("/", name="suisse")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('fascliBdcBundle:suisse')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new suisse entity.
     *
     * @Route("/", name="suisse_create")
     * @Method("POST")
     * @Template("fascliBdcBundle:suisse:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new suisse();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('suisse_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a suisse entity.
    *
    * @param suisse $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(suisse $entity)
    {
        $form = $this->createForm(new suisseType(), $entity, array(
            'action' => $this->generateUrl('suisse_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new suisse entity.
     *
     * @Route("/new", name="suisse_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new suisse();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a suisse entity.
     *
     * @Route("/{id}", name="suisse_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:suisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find suisse entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing suisse entity.
     *
     * @Route("/{id}/edit", name="suisse_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:suisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find suisse entity.');
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
    * Creates a form to edit a suisse entity.
    *
    * @param suisse $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(suisse $entity)
    {
        $form = $this->createForm(new suisseType(), $entity, array(
            'action' => $this->generateUrl('suisse_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing suisse entity.
     *
     * @Route("/{id}", name="suisse_update")
     * @Method("PUT")
     * @Template("fascliBdcBundle:suisse:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:suisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find suisse entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('suisse_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a suisse entity.
     *
     * @Route("/{id}", name="suisse_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliBdcBundle:suisse')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find suisse entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('suisse'));
    }

    /**
     * Creates a form to delete a suisse entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('suisse_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
