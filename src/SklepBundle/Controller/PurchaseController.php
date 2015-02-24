<?php

namespace SklepBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SklepBundle\Entity\Purchase;
use SklepBundle\Form\PurchaseType;

/**
 * Purchase controller.
 *
 * @Route("/purchase")
 */
class PurchaseController extends Controller
{

    /**
     * Lists all Purchase entities.
     *
     * @Route("/", name="purchase")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SklepBundle:Purchase')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Purchase entity.
     *
     * @Route("/", name="purchase_create")
     * @Method("POST")
     * @Template("SklepBundle:Purchase:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Purchase();
        $entity->setUser($this->getUser());
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('purchase', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Purchase entity.
     *
     * @param Purchase $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Purchase $entity)
    {
        $form = $this->createForm(new PurchaseType(), $entity, array(
            'action' => $this->generateUrl('purchase_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Potwierdź zakup'));

        return $form;
    }

    /**
     * Displays a form to create a new Purchase entity.
     *
     * @Route("/new/{id}", name="purchase_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $entity = new Purchase();
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('SklepBundle:Product')->findOneById($id);
        $entity->setProduct($product);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Purchase entity.
     *
     * @Route("/{id}", name="purchase_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SklepBundle:Purchase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Purchase entity.
     *
     * @Route("/{id}/edit", name="purchase_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SklepBundle:Purchase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
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
    * Creates a form to edit a Purchase entity.
    *
    * @param Purchase $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Purchase $entity)
    {
        $form = $this->createForm(new PurchaseType(), $entity, array(
            'action' => $this->generateUrl('purchase_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Aktualizuj'));

        return $form;
    }
    /**
     * Edits an existing Purchase entity.
     *
     * @Route("/{id}", name="purchase_update")
     * @Method("PUT")
     * @Template("SklepBundle:Purchase:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SklepBundle:Purchase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('purchase_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Purchase entity.
     *
     * @Route("/{id}", name="purchase_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SklepBundle:Purchase')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Purchase entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('purchase'));
    }

    /**
     * Creates a form to delete a Purchase entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('purchase_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
