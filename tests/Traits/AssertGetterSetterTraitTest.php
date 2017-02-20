<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Traits;

use DateTime;
use Narrowspark\TestingHelper\Tests\Fixture\MockObject;
use Narrowspark\TestingHelper\Traits\AssertGetterSetterTrait;
use PHPUnit\Framework\TestCase;

class AssertGetterSetterTraitTest extends TestCase
{
    use AssertGetterSetterTrait;

    protected $object;

    public function setUp()
    {
        $this->object = new MockObject();
    }

    public function testGetterOnly()
    {
        $this->assertGetterSetter(
            $this->object,
            'getId'
        );
    }

    public function testGetterAndSetterChainable()
    {
        $this->assertGetterSetter(
            $this->object,
            'getChainable',
            null,
            'setChainable',
            'testing'
        );
    }

    public function testGetterAndSetterNonChainableAsNonChainable()
    {
        $this->assertGetterSetter(
            $this->object,
            'getNonChainable',
            null,
            'setNonChainable',
            'testing',
            false
        );
    }

    public function testGetterAndSetterManipulated()
    {
        $this->assertGetterSetter(
            $this->object,
            'getManipulated',
            null,
            'setManipulated',
            'testing',
            true,
            'TESTING'
        );
    }

    public function testGetterAndSetterDefaultDateDefaultSet()
    {
        $dateTime = new DateTime();

        $this->setPropertyDefaultValue($this->object, 'created', $dateTime);

        $this->assertGetterSetter(
            $this->object,
            'getCreated',
            $dateTime,
            'setCreated',
            new DateTime(),
            true
        );
    }

    public function testGetterSetterArray()
    {
        $this->arrayAssertionRunner(
            $this->object,
            [
                ['getId'],
                ['getChainable', null, 'setChainable', 'value'],
                ['getNonChainable', null, 'setNonChainable', 'value', false],
                ['getManipulated', null, 'setManipulated', 'testing', true, 'TESTING'],
            ],
            [$this, 'assertGetterSetter']
        );
    }

    /**
     * Failure because we can not check the default on properties set during instantiation.
     *
     * @expectedException \PHPUnit\Framework\ExpectationFailedException
     */
    public function testGetterAndSetterDefaultDate()
    {
        $dateTime = new DateTime();

        $this->assertGetterSetter(
            $this->object,
            'getCreated',
            null,
            'setCreated',
            $dateTime,
            true
        );
    }

    /**
     * @expectedException        \PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessage Object does not contain the specified getter method "getNonExistent".
     */
    public function testNonExistentGetter()
    {
        $this->assertGetterSetter(
            $this->object,
            'getNonExistent'
        );
    }

    /**
     * @expectedException        \PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessage Object does not contain the specified setter method "setId".
     */
    public function testGetterAndNonExistentSetter()
    {
        $this->assertGetterSetter(
            $this->object,
            'getId',
            null,
            'setId'
        );
    }

    /**
     * @expectedException        \PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessage Object setter (setNonChainable) is not chainable.
     */
    public function testGetterAndSetterNonChainableAsChainable()
    {
        $this->assertGetterSetter(
            $this->object,
            'getNonChainable',
            null,
            'setNonChainable',
            'testing'
        );
    }
}
