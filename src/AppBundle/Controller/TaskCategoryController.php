<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TaskCategory;
use AppBundle\Form\TaskCategoryType;

/**
 * TaskCategory controller.
 *
 * @Route("/taskcategory")
 */
class TaskCategoryController extends Controller
{
    /**
     * Lists all TaskCategory entities.
     *
     * @Route("/", name="taskcategory_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $taskCategories = $em->getRepository('AppBundle:TaskCategory')->findAll();

        return $this->render('taskcategory/index.html.twig', [
            'taskCategories' => $taskCategories,
        ]);
    }

    /**
     * Creates a new TaskCategory entity.
     *
     * @Route("/new", name="taskcategory_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $taskCategory = new TaskCategory();
        $form = $this->createForm('AppBundle\Form\TaskCategoryType', $taskCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($taskCategory);
            $em->flush();

            return $this->redirectToRoute('taskcategory_index');
        }

        return $this->render('taskcategory/new.html.twig', [
            'taskCategory' => $taskCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a TaskCategory entity.
     *
     * @Route("/{id}", name="taskcategory_show")
     * @Method("GET")
     * @param TaskCategory $taskCategory
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(TaskCategory $taskCategory)
    {
        $deleteForm = $this->createDeleteForm($taskCategory);

        return $this->render('taskcategory/show.html.twig', [
            'taskCategory' => $taskCategory,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing TaskCategory entity.
     *
     * @Route("/{id}/edit", name="taskcategory_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param TaskCategory $taskCategory
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, TaskCategory $taskCategory)
    {
        $deleteForm = $this->createDeleteForm($taskCategory);
        $editForm = $this->createForm('AppBundle\Form\TaskCategoryType', $taskCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($taskCategory);
            $em->flush();

            $this->addFlash('success', 'Änderungen wurden gespeichert.');

            return $this->redirectToRoute('taskcategory_edit', ['id' => $taskCategory->getId()]);
        }

        return $this->render('taskcategory/edit.html.twig', [
            'taskCategory' => $taskCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a TaskCategory entity.
     *
     * @Route("/{id}", name="taskcategory_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param TaskCategory $taskCategory
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, TaskCategory $taskCategory)
    {
        $form = $this->createDeleteForm($taskCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($taskCategory);
            $em->flush();
        }

        return $this->redirectToRoute('taskcategory_index');
    }

    /**
     * Creates a form to delete a TaskCategory entity.
     *
     * @param TaskCategory $taskCategory The TaskCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TaskCategory $taskCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('taskcategory_delete', ['id' => $taskCategory->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
