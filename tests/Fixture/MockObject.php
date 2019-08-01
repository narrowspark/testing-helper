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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getChainable()
    {
        return $this->chainable;
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
    public function getNonChainable()
    {
        return $this->nonChainable;
    }

    /**
     * @param mixed $nonChainable
     */
    public function setNonChainable($nonChainable): void
    {
        $this->nonChainable = $nonChainable;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
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
     * @return mixed
     */
    public function getManipulated()
    {
        return $this->manipulated;
    }

    /**
     * @param mixed $manipulated
     *
     * @return $this
     */
    public function setManipulated($manipulated)
    {
        $this->manipulated = \mb_strtoupper($manipulated);

        return $this;
    }
}
