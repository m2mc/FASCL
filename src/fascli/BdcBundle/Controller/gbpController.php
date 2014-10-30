<?php

namespace fascli\BdcBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use fascli\BdcBundle\Entity\gbp;
use fascli\BdcBundle\Form\gbpType;

/**
 * gbp controller.
 *
 * @Route("/gbp")
 */
class gbpController extends Controller
{

    /**
     * Lists all gbp entities.
     *
     * @Route("/", name="gbp")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('fascliBdcBundle:gbp')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new gbp entity.
     *
     * @Route("/", name="gbp_create")
     * @Method("POST")
     * @Template("fascliBdcBundle:gbp:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new gbp();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gbp_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a gbp entity.
    *
    * @param gbp $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(gbp $entity)
    {
        $form = $this->createForm(new gbpType(), $entity, array(
            'action' => $this->generateUrl('gbp_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new gbp entity.
     *
     * @Route("/new", name="gbp_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new gbp();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a gbp entity.
     *
     * @Route("/{id}", name="gbp_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:gbp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find gbp entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing gbp entity.
     *
     * @Route("/{id}/edit", name="gbp_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:gbp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find gbp entity.');
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
    * Creates a form to edit a gbp entity.
    *
    * @param gbp $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(gbp $entity)
    {
        $form = $this->createForm(new gbpType(), $entity, array(
            'action' => $this->generateUrl('gbp_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing gbp entity.
     *
     * @Route("/{id}", name="gbp_update")
     * @Method("PUT")
     * @Template("fascliBdcBundle:gbp:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:gbp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find gbp entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('gbp_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a gbp entity.
     *
     * @Route("/{id}", name="gbp_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliBdcBundle:gbp')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find gbp entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gbp'));
    }

    /**
     * Creates a form to delete a gbp entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gbp_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
