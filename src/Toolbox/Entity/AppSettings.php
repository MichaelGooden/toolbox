<?php
namespace Toolbox\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation AS Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_settings")
 */
class AppSettings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private $optionId;

    /**
     * @ORM\Column(type="array", nullable=false)
     */
    private $optionValue;

    /**
     * @var datetime $created
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     *
     */
    protected $created;

    /**
     * @var datetime $modified
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     *
     */
    protected $modified;

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * @param mixed $optionId
     */
    public function setOptionId($optionId)
    {
        $this->optionId = $optionId;
    }


    /**
     * @return mixed
     */
    public function getOptionValue()
    {
        return $this->optionValue;
    }

    /**
     * @param mixed $optionValue
     */
    public function setOptionValue($optionValue)
    {
        $this->optionValue = $optionValue;
    }


}