<?php

namespace Toolbox\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Day
 *
 * @ORM\Table(name="exchange_rate")
 * @ORM\Entity
 */
class ExchangeRate
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="id", precision=0, scale=0)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=5, nullable=false, name="from_currency", precision=0, scale=0)
     */
    private $fromCurrency;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=5, nullable=false, name="to_currency", precision=0, scale=0)
     */
    private $toCurrency;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false, name="value")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false, name="inverse")
     */
    private $inverse;

    /**
     * @var datetime $created
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     *
     */
    protected $created;

    /**
     * @var datetime $modified
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     *
     */
    protected $modified;

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
     * Get fromCurrency
     *
     * @return string
     */
    public function getFromCurrency()
    {
        return $this->fromCurrency;
    }

    /**
     * Set fromCurrency
     *
     * @param string $fromCurrency
     * @return ExchangeRate
     */
    public function setFromCurrency($fromCurrency)
    {
        $this->fromCurrency = $fromCurrency;

        return $this;
    }

    /**
     * Get toCurrency
     *
     * @return string
     */
    public function getToCurrency()
    {
        return $this->toCurrency;
    }

    /**
     * Set toCurrency
     *
     * @param string $toCurrency
     * @return ExchangeRate
     */
    public function setToCurrency($toCurrency)
    {
        $this->toCurrency = $toCurrency;

        return $this;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getInverse()
    {
        return $this->inverse;
    }

    /**
     * @param $inverse
     * @return $this
     */
    public function setInverse($inverse)
    {
        $this->inverse = $inverse;

        return $this;
    }

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

}
