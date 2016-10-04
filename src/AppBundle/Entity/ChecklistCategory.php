<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ChecklistCategory
 *
 * @ORM\Table(name="checklist_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChecklistCategoryRepository")
 */
class ChecklistCategory
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var array
     * 
     * @ORM\OneToMany(targetEntity="Checklist", mappedBy="category")
     */
    private $checklists;


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
     * @return ChecklistCategory
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
     * @return ChecklistCategory
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
     * Constructor
     */
    public function __construct()
    {
        $this->checklists = new ArrayCollection();
    }

    /**
     * Add checklist
     *
     * @param Checklist $checklist
     *
     * @return ChecklistCategory
     */
    public function addChecklist(Checklist $checklist)
    {
        $this->checklists[] = $checklist;

        return $this;
    }

    /**
     * Remove checklist
     *
     * @param Checklist $checklist
     */
    public function removeChecklist(Checklist $checklist)
    {
        $this->checklists->removeElement($checklist);
    }

    /**
     * Get checklists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChecklists()
    {
        return $this->checklists;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
