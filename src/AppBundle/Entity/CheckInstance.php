<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CheckInstance
 *
 * @ORM\Table(name="check_instance")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CheckInstanceRepository")
 */
class CheckInstance
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
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", nullable=true)
     */
    private $domain;

    /**
     * @var string
     *
     * @ORM\Column(name="customer", type="string", nullable=true)
     */
    private $customer;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="checkInstances")
     */
    private $assignedUser;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="checkInstances")
     */
    private $user;

    /**
     * @var CheckInstanceCheck[]
     *
     * @ORM\OneToMany(targetEntity="CheckInstanceCheck", mappedBy="checkInstance")
     */
    private $checkInstanceChecks;

    /**
     * @var Checklist
     *
     * @ORM\ManyToOne(targetEntity="Checklist", inversedBy="checkInstances")
     */
    private $checklist;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="text", nullable=true)
     */
    private $info;


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
     * Set title
     *
     * @param string $title
     *
     * @return CheckInstance
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CheckInstance
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
     * @return CheckInstance
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
     * Set checklist
     *
     * @param Checklist $checklist
     *
     * @return CheckInstance
     */
    public function setChecklist(Checklist $checklist = null)
    {
        $this->checklist = $checklist;

        return $this;
    }

    /**
     * Get checklist
     *
     * @return Checklist
     */
    public function getChecklist()
    {
        return $this->checklist;
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
     * @return CheckInstance
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

    /**
     * Set domain
     *
     * @param string $domain
     *
     * @return CheckInstance
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set customer
     *
     * @param string $customer
     *
     * @return CheckInstance
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set assignedUser
     *
     * @param \AppBundle\Entity\User $assignedUser
     *
     * @return CheckInstance
     */
    public function setAssignedUser(\AppBundle\Entity\User $assignedUser = null)
    {
        $this->assignedUser = $assignedUser;

        return $this;
    }

    /**
     * Get assignedUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getAssignedUser()
    {
        return $this->assignedUser;
    }

    /**
     * Set info
     *
     * @param string $info
     *
     * @return CheckInstance
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }
}
