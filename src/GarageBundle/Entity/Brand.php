<?php

namespace GarageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Brand
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity(repositoryClass="GarageBundle\Repository\BrandRepository")
 */
class Brand
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="univers", type="string", length=255)
     */
    private $univers;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="GarageBundle\Entity\Car", mappedBy="brand")
     */
    private $cars;

    /**
     * Brand constructor.
     */
    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Brand
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
     * Set univers
     *
     * @param string $univers
     * @return Brand
     */
    public function setUnivers($univers)
    {
        $this->univers = $univers;

        return $this;
    }

    /**
     * Get univers
     *
     * @return string 
     */
    public function getUnivers()
    {
        return $this->univers;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Brand
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Brand
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add cars
     *
     * @param \GarageBundle\Entity\Car $cars
     * @return Brand
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
