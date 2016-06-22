<?php

namespace AppBundle\Entity;

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
     * @var bool
     *
     * @ORM\Column(name="checked", type="boolean", nullable=true)
     */
    private $checked;

    /**
     * @var Checklist
     *
     * @ORM\ManyToOne(targetEntity="Checklist")
     */
    private $checklist;

    /**
     * @var TaskCategory
     *
     * @ORM\ManyToOne(targetEntity="TaskCategory")
     */
    private $taskCategory;


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
     * Set checked
     *
     * @param boolean $checked
     *
     * @return Task
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;

        return $this;
    }

    /**
     * Get checked
     *
     * @return bool
     */
    public function isChecked()
    {
        return $this->checked;
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
}

