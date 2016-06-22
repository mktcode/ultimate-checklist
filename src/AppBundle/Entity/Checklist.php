<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Checklist
 *
 * @ORM\Table(name="checklist")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChecklistRepository")
 */
class Checklist
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Task[]
     *
     * @ORM\OneToMany(targetEntity="Task", mappedBy="checklist")
     */
    private $tasks;

    /**
     * @var CheckInstance[]
     *
     * @ORM\OneToMany(targetEntity="CheckInstance", mappedBy="checklist")
     */
    private $checkInstances;


    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->checkInstances = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Checklist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add task
     *
     * @param Task $task
     *
     * @return Checklist
     */
    public function addTask(Task $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Remove task
     *
     * @param Task $task
     */
    public function removeTask(Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add checkInstance
     *
     * @param CheckInstance $checkInstance
     *
     * @return Checklist
     */
    public function addCheckInstance(CheckInstance $checkInstance)
    {
        $this->checkInstances[] = $checkInstance;

        return $this;
    }

    /**
     * Remove checkInstance
     *
     * @param CheckInstance $checkInstance
     */
    public function removeCheckInstance(CheckInstance $checkInstance)
    {
        $this->checkInstances->removeElement($checkInstance);
    }

    /**
     * Get checkInstances
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCheckInstances()
    {
        return $this->checkInstances;
    }
}
