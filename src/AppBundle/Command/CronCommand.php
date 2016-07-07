<?php

namespace AppBundle\Command;

use AppBundle\Entity\CheckInstance;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;

class CronCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('checklist:cron')
            ->setDescription('Command to be constantly called by cron');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Exception
     * @throws \Symfony\Component\Console\Exception\ExceptionInterface
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $helper = $this->getContainer()->get('app.helper');
        $users = $em->getRepository('AppBundle:User')->findAll();
        $deadlineReminderSpan = $this->getContainer()->getParameter('deadline_reminder_span');
        $deadlineReminderInterval = $this->getContainer()->getParameter('deadline_reminder_interval');

        foreach ($users as $user) {
            // send email notifications for upcoming deadlines
            /** @var CheckInstance $checkInstance */
            foreach ($user->getCheckInstances() as $checkInstance) {
                if (
                    // has assigned user
                    $checkInstance->getAssignedUser()
                    // has deadline
                    && $checkInstance->getDeadline()
                    // is not complete
                    && $helper->getCheckInstanceProgress($checkInstance) < 100
                    // deadline is withing reminder span
                    && $checkInstance->getDeadline()->getTimestamp() - time() < $deadlineReminderSpan
                    // reminder hasn't been sent for a configured amount of time
                    && (!$checkInstance->getDeadlineReminderLastSent() || time() - $checkInstance->getDeadlineReminderLastSent()->getTimestamp() > $deadlineReminderInterval)
                ) {
                    // send mail
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Deadline! Checkliste: ' . $checkInstance->getTitle())
                        ->setFrom(['dev@crea.de' => 'Crea Checklisten'])
                        ->setTo($checkInstance->getAssignedUser()->getEmail())
                        ->setBody(
                            $this->getContainer()->get('templating')->render('default/mailDeadline.html.twig', [
                                'checkInstance' => $checkInstance,
                                'link' => $this->getContainer()->get('router')->generate('check_task', [
                                    'checkInstance' => $checkInstance->getInfo()
                                ], UrlGenerator::ABSOLUTE_URL)
                            ]),
                            'text/html'
                        );
                    $result = $this->getContainer()->get('mailer')->send($message);

                    // update last sent timestamp
                    if ($result) {
                        $checkInstance->setDeadlineReminderLastSent(new \DateTime());
                        $em->flush();
                    }
                }
            }
        }
    }
}
