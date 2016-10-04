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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var Task[]
     *
     * @ORM\OneToMany(targetEntity="Task", mappedBy="checklist")
     * @ORM\OrderBy(value={"orderNum" = "ASC"})
     */
    private $tasks;

    /**
     * @var CheckInstance[]
     *
     * @ORM\OneToMany(targetEntity="CheckInstance", mappedBy="checklist")
     * @ORM\OrderBy(value={"date" = "DESC"})
     */
    private $checkInstances;

    /**
     * @var ChecklistCategory
     *
     * @ORM\ManyToOne(targetEntity="ChecklistCategory", inversedBy="checklists")
     */
    private $category;


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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Checklist
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set category
     *
     * @param ChecklistCategory $category
     *
     * @return Checklist
     */
    public function setCategory(ChecklistCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return ChecklistCategory
     */
    public function getCategory()
    {
        return $this->category;
    }
}
