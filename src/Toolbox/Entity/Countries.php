<?php
namespace Toolbox\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Countries
 *
 * @ORM\Table(name="countries", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Countries
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="string", length=2, nullable=true, name="iso2")
     */
    private $code2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=3, nullable=true, name="iso3")
     */
    private $code3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="name")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true, name="gmt")
     */
    private $gmt;


    /**
     * Get userId
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get code2
     *
     * @return string
     */
    public function getCode2()
    {
        return $this->code2;
    }

    /**
     * Get code3
     *
     * @return string
     */
    public function getCode3()
    {
        return $this->code3;
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
     * Get gmt
     *
     * @return integer
     */
    public function getGmt()
    {
        return $this->gmt;
    }

}
