<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\CheckInstance;
use AppBundle\Form\CheckInstanceType;

/**
 * CheckInstance controller.
 *
 * @Route("/checks")
 */
class CheckInstanceController extends Controller
{
    /**
     * Lists all CheckInstance entities.
     *
     * @Route("/", name="checkinstance_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $checkInstances = $em->getRepository('AppBundle:CheckInstance')->findBy([], ['date' => 'DESC']);

        return $this->render('checkinstance/index.html.twig', array(
            'checkInstances' => $checkInstances,
        ));
    }

    /**
     * Creates a new CheckInstance entity.
     *
     * @Route("/new", name="checkinstance_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $checkInstance = new CheckInstance();
        $form = $this->createForm('AppBundle\Form\CheckInstanceType', $checkInstance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($checkInstance);
            $em->flush();

            return $this->redirectToRoute('checkinstance_show', array('id' => $checkInstance->getId()));
        }

        return $this->render('checkinstance/new.html.twig', array(
            'checkInstance' => $checkInstance,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CheckInstance entity.
     *
     * @Route("/{id}", name="checkinstance_show")
     * @Method("GET")
     */
    public function showAction(CheckInstance $checkInstance)
    {
        $deleteForm = $this->createDeleteForm($checkInstance);

        return $this->render('checkinstance/show.html.twig', array(
            'checkInstance' => $checkInstance,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CheckInstance entity.
     *
     * @Route("/{id}/edit", name="checkinstance_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CheckInstance $checkInstance)
    {
        $deleteForm = $this->createDeleteForm($checkInstance);
        $editForm = $this->createForm('AppBundle\Form\CheckInstanceType', $checkInstance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($checkInstance);
            $em->flush();

            $this->addFlash('success', 'Änderungen wurden gespeichert.');

            return $this->redirectToRoute('checkinstance_edit', array('id' => $checkInstance->getId()));
        }

        return $this->render('checkinstance/edit.html.twig', array(
            'checkInstance' => $checkInstance,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CheckInstance entity.
     *
     * @Route("/{id}", name="checkinstance_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CheckInstance $checkInstance)
    {
        $form = $this->createDeleteForm($checkInstance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($checkInstance);
            $em->flush();
        }

        return $this->redirectToRoute('checkinstance_index');
    }

    /**
     * Creates a form to delete a CheckInstance entity.
     *
     * @param CheckInstance $checkInstance The CheckInstance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CheckInstance $checkInstance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('checkinstance_delete', array('id' => $checkInstance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
