<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Traits;

use DateTime;
use Narrowspark\TestingHelper\Tests\Fixture\MockObject;
use Narrowspark\TestingHelper\Traits\AssertGetterSetterTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertGetterSetterTraitTest extends TestCase
{
    use AssertGetterSetterTrait;

    protected $object;

    protected function setUp(): void
    {
        $this->object = new MockObject();
    }

    public function testGetterOnly(): void
    {
        self::assertGetterSetter(
            $this->object,
            'getId'
        );
    }

    public function testGetterAndSetterChainable(): void
    {
        self::assertGetterSetter(
            $this->object,
            'getChainable',
            null,
            'setChainable',
            'testing'
        );
    }

    public function testGetterAndSetterNonChainableAsNonChainable(): void
    {
        self::assertGetterSetter(
            $this->object,
            'getNonChainable',
            null,
            'setNonChainable',
            'testing',
            false
        );
    }

    public function testGetterAndSetterManipulated(): void
    {
        self::assertGetterSetter(
            $this->object,
            'getManipulated',
            null,
            'setManipulated',
            'testing',
            true,
            'TESTING'
        );
    }

    public function testGetterAndSetterDefaultDateDefaultSet(): void
    {
        $dateTime = new DateTime();

        $this->setPropertyDefaultValue($this->object, 'created', $dateTime);

        self::assertGetterSetter(
            $this->object,
            'getCreated',
            $dateTime,
            'setCreated',
            new DateTime(),
            true
        );
    }

    public function testGetterSetterArray(): void
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
     */
    public function testGetterAndSetterDefaultDate(): void
    {
        $this->expectException(\PHPUnit\Framework\ExpectationFailedException::class);

        $dateTime = new DateTime();

        self::assertGetterSetter(
            $this->object,
            'getCreated',
            null,
            'setCreated',
            $dateTime,
            true
        );
    }

    public function testNonExistentGetter(): void
    {
        $this->expectException(\PHPUnit\Framework\ExpectationFailedException::class);
        $this->expectExceptionMessage('Object does not contain the specified getter method "getNonExistent".');

        self::assertGetterSetter(
            $this->object,
            'getNonExistent'
        );
    }

    public function testGetterAndNonExistentSetter(): void
    {
        $this->expectException(\PHPUnit\Framework\ExpectationFailedException::class);
        $this->expectExceptionMessage('Object does not contain the specified setter method "setId".');

        self::assertGetterSetter(
            $this->object,
            'getId',
            null,
            'setId'
        );
    }

    public function testGetterAndSetterNonChainableAsChainable(): void
    {
        $this->expectException(\PHPUnit\Framework\ExpectationFailedException::class);
        $this->expectExceptionMessage('Object setter (setNonChainable) is not chainable.');

        self::assertGetterSetter(
            $this->object,
            'getNonChainable',
            null,
            'setNonChainable',
            'testing'
        );
    }
}
