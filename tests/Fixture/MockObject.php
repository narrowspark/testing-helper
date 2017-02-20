<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Fixture;

use DateTime;

class MockObject
{
    protected $id;

    protected $chainable;

    protected $nonChainable;

    protected $created;

    protected $manipulated;

    /**
     * Assigns defaults to certain properties.
     */
    public function __construct()
    {
        $this->created = new DateTime();
    }

    /**
     * @param mixed $chainable
     *
     * @return $this
     */
    public function setChainable($chainable)
    {
        $this->chainable = $chainable;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChainable()
    {
        return $this->chainable;
    }

    /**
     * @param \DateTime $created
     *
     * @return $this
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $nonChainable
     */
    public function setNonChainable($nonChainable)
    {
        $this->nonChainable = $nonChainable;
    }

    /**
     * @return mixed
     */
    public function getNonChainable()
    {
        return $this->nonChainable;
    }

    /**
     * @param mixed $manipulated
     *
     * @return $this
     */
    public function setManipulated($manipulated)
    {
        $this->manipulated = mb_strtoupper($manipulated);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getManipulated()
    {
        return $this->manipulated;
    }
}
