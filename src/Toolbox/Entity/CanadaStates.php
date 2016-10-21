<?php
namespace Toolbox\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CanadaStates
 *
 * @ORM\Table(name="states_canada", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class CanadaStates
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
     * @ORM\Column(type="string", length=255, nullable=true, name="name")
     */
    private $name;

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


}
