<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaskRepository")
 */
class Task
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
     * @var Checklist
     *
     * @ORM\ManyToOne(targetEntity="Checklist", inversedBy="tasks")
     */
    private $checklist;

    /**
     * @var TaskCategory
     *
     * @ORM\ManyToOne(targetEntity="TaskCategory", inversedBy="tasks")
     */
    private $taskCategory;

    /**
     * @var integer
     *
     * @ORM\Column(name="order_num", type="integer")
     */
    private $orderNum;

    /**
     * @var CheckInstanceCheck[]
     *
     * @ORM\OneToMany(targetEntity="CheckInstanceCheck", mappedBy="task")
     */
    private $checkInstanceChecks;


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
     * @return Task
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
     * Set description
     *
     * @param string $description
     *
     * @return Task
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
     * @return Checklist
     */
    public function getChecklist()
    {
        return $this->checklist;
    }

    /**
     * @param Checklist $checklist
     * @return $this
     */
    public function setChecklist(Checklist $checklist)
    {
        $this->checklist = $checklist;

        return $this;
    }

    /**
     * @return TaskCategory
     */
    public function getTaskCategory()
    {
        return $this->taskCategory;
    }

    /**
     * @param TaskCategory $taskCategory
     * @return $this
     */
    public function setTaskCategory(TaskCategory $taskCategory)
    {
        $this->taskCategory = $taskCategory;

        return $this;
    }

    /**
     * Set orderNum
     *
     * @param integer $orderNum
     *
     * @return Task
     */
    public function setOrderNum($orderNum)
    {
        $this->orderNum = $orderNum;

        return $this;
    }

    /**
     * Get orderNum
     *
     * @return integer
     */
    public function getOrderNum()
    {
        return $this->orderNum;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->checkInstanceChecks = new ArrayCollection();
    }

    /**
     * Add checkInstanceCheck
     *
     * @param CheckInstanceCheck $checkInstanceCheck
     *
     * @return Task
     */
    public function addCheckInstanceCheck(CheckInstanceCheck $checkInstanceCheck)
    {
        $this->checkInstanceChecks[] = $checkInstanceCheck;

        return $this;
    }

    /**
     * Remove checkInstanceCheck
     *
     * @param CheckInstanceCheck $checkInstanceCheck
     */
    public function removeCheckInstanceCheck(CheckInstanceCheck $checkInstanceCheck)
    {
        $this->checkInstanceChecks->removeElement($checkInstanceCheck);
    }

    /**
     * Get checkInstanceChecks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCheckInstanceChecks()
    {
        return $this->checkInstanceChecks;
    }
}
