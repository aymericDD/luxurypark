<?php
// src/AppBundle/Entity/User.php

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
     * @ORM\OneToMany(targetEntity="GarageBundle\Entity\Car", mappedBy="user")
     */
    private $cars;

    public function __construct()
    {
        parent::__construct();
        $this->cars = new ArrayCollection();
    }

    /**
     * Add cars
     *
     * @param \GarageBundle\Entity\Car $cars
     * @return User
     */
    public function addCar(\GarageBundle\Entity\Car $cars)
    {
        $this->cars[] = $cars;

        return $this;
    }

    /**
     * Remove cars
     *
     * @param \GarageBundle\Entity\Car $cars
     */
    public function removeCar(\GarageBundle\Entity\Car $cars)
    {
        $this->cars->removeElement($cars);
    }

    /**
     * Get cars
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCars()
    {
        return $this->cars;
    }
}
