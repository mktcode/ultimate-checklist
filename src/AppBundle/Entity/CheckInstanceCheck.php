<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CheckInstanceCheck
 *
 * @ORM\Table(name="check_instance_check")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CheckInstanceCheckRepository")
 */
class CheckInstanceCheck
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="checkInstanceChecks")
     */
    private $user;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="CheckInstance", inversedBy="checkInstanceChecks")
     */
    private $checkInstance;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="checkInstanceChecks")
     */
    private $task;

    /**
     * @var boolean
     *
     * @ORM\Column(name="checked", type="boolean")
     */
    private $checked;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CheckInstanceCheck
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return CheckInstanceCheck
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set checkInstance
     *
     * @param CheckInstance $checkInstance
     *
     * @return CheckInstanceCheck
     */
    public function setCheckInstance(CheckInstance $checkInstance = null)
    {
        $this->checkInstance = $checkInstance;

        return $this;
    }

    /**
     * Get checkInstance
     *
     * @return CheckInstance
     */
    public function getCheckInstance()
    {
        return $this->checkInstance;
    }

    /**
     * Set task
     *
     * @param Task $task
     *
     * @return CheckInstanceCheck
     */
    public function setTask(Task $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return \AppBundle\Entity\Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set checked
     *
     * @param boolean $checked
     *
     * @return CheckInstanceCheck
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;

        return $this;
    }

    /**
     * Get checked
     *
     * @return boolean
     */
    public function isChecked()
    {
        return $this->checked;
    }
}
