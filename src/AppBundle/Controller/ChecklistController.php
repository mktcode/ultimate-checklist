<?php

namespace AppBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Checklist;

/**
 * Checklist controller.
 *
 * @Route("/checklist")
 */
class ChecklistController extends Controller
{
    /**
     * Lists all Checklist entities.
     *
     * @Route("/", name="checklist_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $checklists = $em->getRepository('AppBundle:Checklist')->findAll();

        $deleteButtons = [];
        /** @var Checklist $checklist */
        foreach ($checklists as $checklist) {
            $deleteButtons[$checklist->getId()] = $this->createDeleteForm($checklist)->createView();
        }

        return $this->render('checklist/index.html.twig', [
            'checklists' => $checklists,
            'deleteButtons' => $deleteButtons
        ]);
    }

    /**
     * Creates a new Checklist entity.
     *
     * @Route("/new", name="checklist_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $checklist = new Checklist();
        $form = $this->createForm('AppBundle\Form\ChecklistType', $checklist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($checklist);
            $em->flush();

            return $this->redirectToRoute('checklist_show', ['id' => $checklist->getId()]);
        }

        return $this->render('checklist/new.html.twig', [
            'checklist' => $checklist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Checklist entity.
     *
     * @Route("/{id}", name="checklist_show")
     * @Method("GET")
     * @param Checklist $checklist
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Checklist $checklist)
    {
        $deleteForm = $this->createDeleteForm($checklist);

        return $this->render('checklist/show.html.twig', [
            'checklist' => $checklist,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Checklist entity.
     *
     * @Route("/{id}/edit", name="checklist_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Checklist $checklist
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Checklist $checklist)
    {
        $deleteForm = $this->createDeleteForm($checklist);
        $editForm = $this->createForm('AppBundle\Form\ChecklistType', $checklist);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($checklist);
            $em->flush();

            return $this->redirectToRoute('checklist_edit', ['id' => $checklist->getId()]);
        }

        return $this->render('checklist/edit.html.twig', [
            'checklist' => $checklist,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Checklist entity.
     *
     * @Route("/{id}", name="checklist_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Checklist $checklist
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Checklist $checklist)
    {
        $form = $this->createDeleteForm($checklist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($checklist);
            $em->flush();
        }

        return $this->redirectToRoute('checklist_index');
    }

    /**
     * Creates a form to delete a Checklist entity.
     *
     * @param Checklist $checklist The Checklist entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Checklist $checklist)
    {
        return $this->createFormBuilder()
            ->add('delete', SubmitType::class, ['label' => '<i class="uk-icon-trash"></i>'])
            ->setAction($this->generateUrl('checklist_delete', ['id' => $checklist->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
