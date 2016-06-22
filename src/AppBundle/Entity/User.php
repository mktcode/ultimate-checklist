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

    public function __construct()
    {
        parent::__construct();

        $this->checkInstances = new ArrayCollection();
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
}
