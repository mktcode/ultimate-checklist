<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CheckInstance;
use AppBundle\Entity\CheckInstanceCheck;
use AppBundle\Entity\Checklist;
use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/check", name="check")
     */
    public function checkAction()
    {
        $em = $this->getDoctrine()->getManager();
        $checklists = $em->getRepository('AppBundle:Checklist')->findAll();

        return $this->render('default/check.html.twig', [
            'checklists' => $checklists
        ]);
    }

    /**
     * @Route("/check/new/{checklist}", name="check_new")
     */
    public function checkNewAction(Request $request, Checklist $checklist)
    {
        $em = $this->getDoctrine()->getManager();

        $checkInstance = new CheckInstance();
        $form = $this->createForm('AppBundle\Form\CheckInstanceNewType', $checkInstance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $checkInstance->setChecklist($checklist);
            $checkInstance->setDate(new \DateTime());
            $checkInstance->setUser($this->getUser());
            $em->persist($checkInstance);
            $em->flush();

            if ($form->get('sendMail')->getData() && $checkInstance->getAssignedUser()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Checkliste bearbeiten: ' . $checkInstance->getTitle())
                    ->setFrom('dev@crea.de')
                    ->setTo($checkInstance->getAssignedUser()->getEmail())
                    ->setBody(
                        $this->renderView('default/mailNew.html.twig', ['checkInstance' => $checkInstance]),
                        'text/html'
                    );
                $this->get('mailer')->send($message);
            }

            $nextTask = $em->getRepository('AppBundle:Task')->getNextTask($checklist);

            return $this->redirectToRoute('check_task', ['checkInstance' => $checkInstance->getId(), 'task' => $nextTask->getId()]);
        }

        return $this->render('default/checkNew.html.twig', [
            'checklist' => $checklist,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/check/{checkInstance}/{task}", name="check_task", defaults={"task" = ""})
     */
    public function checkTaskAction(CheckInstance $checkInstance, Task $task = null)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$task) {
            $task = $em->getRepository('AppBundle:Task')->getNextTask($checkInstance->getChecklist());
        }

        $nextTask = $em->getRepository('AppBundle:Task')->getNextTask($checkInstance->getChecklist(), $task);
        $prevTask = $em->getRepository('AppBundle:Task')->getPrevTask($checkInstance->getChecklist(), $task);

        $check = $em->getRepository('AppBundle:CheckInstanceCheck')->findOneBy([
            'checkInstance' => $checkInstance,
            'task' => $task
        ]);

        return $this->render('default/checkTask.html.twig', [
            'checkInstance' => $checkInstance,
            'check' => $check,
            'task' => $task,
            'nextTask' => $nextTask,
            'prevTask' => $prevTask
        ]);
    }

    /**
     * @Route("/check/{checkInstance}/{task}/check", name="check_task_check")
     */
    public function checkTaskCheckAction(CheckInstance $checkInstance, Task $task)
    {
        $em = $this->getDoctrine()->getManager();
        
        $check = $em->getRepository('AppBundle:CheckInstanceCheck')->findOneBy([
            'checkInstance' => $checkInstance,
            'task' => $task
        ]);

        if (!$check) {
            $check = new CheckInstanceCheck();
            $check->setCheckInstance($checkInstance);
            $check->setTask($task);
            $em->persist($check);
        }

        $check->setUser($this->getUser());
        $check->setDate(new \DateTime());
        $check->setChecked(!$check->isChecked());

        $em->flush();

        $percentage = $this->get('app.helper')->getCheckInstanceProgress($checkInstance);

        // send mail if 100%
        if ($percentage == 100) {
            // send mail
            $message = \Swift_Message::newInstance()
                ->setSubject('Fertig! Checkliste: ' . $checkInstance->getTitle())
                ->setFrom(['dev@crea.de' => 'Crea Checklisten'])
                ->setTo($checkInstance->getUser()->getEmail())
                ->setBody(
                    $this->renderView('default/mailComplete.html.twig', ['checkInstance' => $checkInstance]),
                    'text/html'
                );
            $this->get('mailer')->send($message);
        }

        return new JsonResponse(json_encode([
            'checked' => $check->isChecked(),
            'user' => $check->getUser()->getUsername(),
            'date' => $check->getDate()->format('d.m.Y H:i'),
            'percentage' => $percentage
        ]));
    }
}
