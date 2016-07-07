<?php

namespace AppBundle\Twig;

use AppBundle\Entity\CheckInstance;
use AppBundle\Entity\CheckInstanceCheck;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Service\Helper;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppExtension extends \Twig_Extension
{
    /**
     * @var Helper
     */
    private $helper;

    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('isChecked', [$this, 'isCheckedFilter']),
            new \Twig_SimpleFilter('checkedBy', [$this, 'checkedByFilter']),
            new \Twig_SimpleFilter('checkedDate', [$this, 'checkedDateFilter']),
            new \Twig_SimpleFilter('checkProgress', [$this, 'checkProgressFilter']),
            new \Twig_SimpleFilter('points', [$this, 'pointsFilter']),
        ];
    }

    public function isCheckedFilter(Task $task, CheckInstance $checkInstance)
    {
        return $this->helper->isTaskChecked($task, $checkInstance);
    }

    public function checkedByFilter(Task $task, CheckInstance $checkInstance)
    {
        return $this->helper->getTaskCheckedBy($task, $checkInstance);
    }

    public function checkedDateFilter(Task $task, CheckInstance $checkInstance)
    {
        return $this->helper->getTaskCheckedDate($task, $checkInstance);
    }

    public function checkProgressFilter(CheckInstance $checkInstance)
    {
        return $this->helper->getCheckInstanceProgress($checkInstance);
    }

    public function pointsFilter(User $user)
    {
        return $this->helper->getPointsForUser($user);
    }

    public function getName()
    {
        return 'app_extension';
    }
}