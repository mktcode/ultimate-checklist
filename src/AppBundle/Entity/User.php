<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var CheckInstance[]
     *
     * @ORM\OneToMany(targetEntity="CheckInstance", mappedBy="user")
     */
    private $checkInstances;

    /**
     * @var CheckInstanceCheck[]
     *
     * @ORM\OneToMany(targetEntity="CheckInstanceCheck", mappedBy="user")
     */
    private $checkInstanceChecks;

    public function __construct()
    {
        parent::__construct();

        $this->checkInstances = new ArrayCollection();
        $this->checkInstanceChecks = new ArrayCollection();
    }

    /**
     * Add checkInstance
     *
     * @param \AppBundle\Entity\CheckInstance $checkInstance
     *
     * @return User
     */
    public function addCheckInstance(CheckInstance $checkInstance)
    {
        $this->checkInstances[] = $checkInstance;

        return $this;
    }

    /**
     * Remove checkInstance
     *
     * @param \AppBundle\Entity\CheckInstance $checkInstance
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
     * Add checkInstanceCheck
     *
     * @param CheckInstanceCheck $checkInstanceCheck
     *
     * @return User
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
