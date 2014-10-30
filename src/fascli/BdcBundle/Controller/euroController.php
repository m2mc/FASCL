<?php

namespace fascli\BdcBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use fascli\BdcBundle\Entity\euro;
use fascli\BdcBundle\Form\euroType;

/**
 * euro controller.
 *
 * @Route("/euro")
 */
class euroController extends Controller
{

    /**
     * Lists all euro entities.
     *
     * @Route("/", name="euro")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ar = array();
        $ar['0'] = '1'; $ar['1'] = '5'; $ar['2'] = '10'; $ar['3'] = '20'; $ar['4'] = '25'; $ar['5'] = '50';
        $ar['6'] = '100'; $ar['7'] = '200'; $ar['8'] = '500';
       foreach ($ar as $value) {

       $resultsVentes = $em->getRepository('fascliBdcBundle:euro')->getV();
       //getVentesDeviseCoupure('EURO', $value);  
       var_dump($resultsVentes['0']['id']);
       var_dump(COUNT($resultsVentes));
       foreach($resultsVentes as $resultVente){
          $qv = $resultVente->getQterest();
          $tv = $resultVente->getTauxreel();
          $m = $resultVente->getMarge();
          $dat = $resultVente->getOperationbdc()->getDatope();
          $resultsAchats = $em->getRepository('fascliBdcBundle:euro')->getAchatsDeviseCoupure('EURO', $value,$dat);

          foreach($resultsAchats as $resultAchat){
            $qa = $resultAchat->getQterest();
            $ta = $resultAchat->getTauxreel();
            if(($qv!='0') && ($qv<=$qa)){
             
             $qv_temp = '0';
             $qa_temp = $qa - $qv;
             $qcalcul = $qv;
             $tcalcul = $tv - $ta;
             $m_temp = $m + ($tcalcul*$qcalcul);
             // Modification des lignes en base de donnees
             $resultAchat->setQterest($qa_temp);
             $resultVente->setQterest($qv_temp);
             $resultVente->setMarge($m_temp);
             // Insertion en base de données
             $em = $this->getDoctrine()->getManager();
             $em->persist($resultVente);
             $em->persist($resultAchat);
             $em->flush();
            }
            else if(($qa != '0') && ($qv>$qa)) {
             
             $qv_temp = $qv - $qa;
             $qa_temp = '0';
             $qcalcul = $qa;
             $tcalcul = $tv - $ta;
             $m_temp = $m + ($tcalcul*$qcalcul);
             // Modification des lignes en base de donnees
             $resultAchat->setQterest($qa_temp);
             $resultVente->setQterest($qv_temp);
             $resultVente->setMarge($m_temp);
             // Insertion en base de données
             $em = $this->getDoctrine()->getManager();
             $em->persist($resultVente);
             $em->persist($resultAchat);
             $em->flush();
            }
           
          }
       }
    }
        $entities = $em->getRepository('fascliBdcBundle:euro')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new euro entity.
     *
     * @Route("/", name="euro_create")
     * @Method("POST")
     * @Template("fascliBdcBundle:euro:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new euro();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('euro_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a euro entity.
    *
    * @param euro $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(euro $entity)
    {
        $form = $this->createForm(new euroType(), $entity, array(
            'action' => $this->generateUrl('euro_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new euro entity.
     *
     * @Route("/new", name="euro_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new euro();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a euro entity.
     *
     * @Route("/{id}", name="euro_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:euro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find euro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing euro entity.
     *
     * @Route("/{id}/edit", name="euro_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:euro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find euro entity.');
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
    * Creates a form to edit a euro entity.
    *
    * @param euro $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(euro $entity)
    {
        $form = $this->createForm(new euroType(), $entity, array(
            'action' => $this->generateUrl('euro_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing euro entity.
     *
     * @Route("/{id}", name="euro_update")
     * @Method("PUT")
     * @Template("fascliBdcBundle:euro:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('fascliBdcBundle:euro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find euro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('euro_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a euro entity.
     *
     * @Route("/{id}", name="euro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('fascliBdcBundle:euro')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find euro entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('euro'));
    }

    /**
     * Creates a form to delete a euro entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('euro_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
