<?php

namespace AppBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ChecklistCategory;
use AppBundle\Form\ChecklistCategoryType;

/**
 * ChecklistCategory controller.
 *
 * @Route("/checklistcategory")
 */
class ChecklistCategoryController extends Controller
{
    /**
     * Lists all ChecklistCategory entities.
     *
     * @Route("/", name="checklistcategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $checklistCategories = $em->getRepository('AppBundle:ChecklistCategory')->findAll();

        $deleteButtons = [];
        /** @var ChecklistCategory $checklist */
        foreach ($checklistCategories as $checklistCategory) {
            $deleteButtons[$checklistCategory->getId()] = $this->createDeleteForm($checklistCategory)->createView();
        }

        return $this->render('checklistcategory/index.html.twig', [
            'checklistCategories' => $checklistCategories,
            'deleteButtons' => $deleteButtons
        ]);
    }

    /**
     * Creates a new ChecklistCategory entity.
     *
     * @Route("/new", name="checklistcategory_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $checklistCategory = new ChecklistCategory();
        $form = $this->createForm('AppBundle\Form\ChecklistCategoryType', $checklistCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($checklistCategory);
            $em->flush();

            return $this->redirectToRoute('checklistcategory_index');
        }

        return $this->render('checklistcategory/new.html.twig', [
            'checklistCategory' => $checklistCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing ChecklistCategory entity.
     *
     * @Route("/{id}/edit", name="checklistcategory_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ChecklistCategory $checklistCategory)
    {
        $editForm = $this->createForm('AppBundle\Form\ChecklistCategoryType', $checklistCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($checklistCategory);
            $em->flush();

            return $this->redirectToRoute('checklistcategory_edit', ['id' => $checklistCategory->getId()]);
        }

        return $this->render('checklistcategory/edit.html.twig', [
            'checklistCategory' => $checklistCategory,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a ChecklistCategory entity.
     *
     * @Route("/{id}", name="checklistcategory_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ChecklistCategory $checklistCategory)
    {
        $form = $this->createDeleteForm($checklistCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($checklistCategory);
            $em->flush();
        }

        return $this->redirectToRoute('checklistcategory_index');
    }

    /**
     * Creates a form to delete a ChecklistCategory entity.
     *
     * @param ChecklistCategory $checklistCategory The ChecklistCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ChecklistCategory $checklistCategory)
    {
        return $this->createFormBuilder()
            ->add('delete', SubmitType::class, ['label' => '<i class="uk-icon-trash"></i>'])
            ->setAction($this->generateUrl('checklistcategory_delete', ['id' => $checklistCategory->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
