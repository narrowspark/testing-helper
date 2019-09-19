<?php

declare(strict_types=1);

namespace Narrowspark\TestingHelper\Tests\Unit\Constraint;

use Narrowspark\TestingHelper\Constraint\UsesTraits;
use Narrowspark\TestingHelper\Traits\AssertObjectTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @small
 */
final class UsesTraitsTest extends TestCase
{
    public function testCountReturnsExpectedValue(): void
    {
        $target = new UsesTraits(['one', 'two', 'three']);

        self::assertEquals(3, $target->count());
    }

    public function testToStringReturnsExpectedValue(): void
    {
        $target = new UsesTraits();

        self::assertEquals('uses required traits', $target->toString());
    }

    public function testEvaluateReturnsTrueIfClassesAreImplemented(): void
    {
        $subject = new class() {
            use AssertObjectTrait;
        };

        $target = new UsesTraits([AssertObjectTrait::class]);

        self::assertTrue($target->evaluate($subject, '', true));
    }

    public function testEvaluateThrowsExceptionWithCorrectFailureDescription(): void
    {
        $class = new class() {
            use AssertObjectTrait;
        };
        $subject = new \ReflectionClass($class);

        $target = new UsesTraits(['nonExistentTrait', AssertObjectTrait::class]);

        try {
            $target->evaluate($subject);
            self::fail('Expected exception of type ' . \PHPUnit\Framework\ExpectationFailedException::class . ' but none was thrown.');
        } catch (\PHPUnit\Framework\ExpectationFailedException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('+ ' . AssertObjectTrait::class, $message);
            self::assertStringContainsString('- nonExistentTrait', $message);
        }
    }

    public function testEvaluateThrowsExceptionWithCorrectDescriptionFromString(): void
    {
        $subject = new class() {
        };
        $class = \get_class($subject);
        $target = new UsesTraits([AssertObjectTrait::class]);

        $this->expectException(\PHPUnit\Framework\Exception::class);
        $this->expectExceptionMessage($class);

        $target->evaluate($class);
    }

    public function testEvaluateThrowsExceptionWithCorrectDescriptionFromObject(): void
    {
        $subject = new class() extends \ArrayObject {
        };
        $class = \get_class($subject);
        $target = new UsesTraits([AssertObjectTrait::class]);

        $this->expectException(\PHPUnit\Framework\Exception::class);
        $this->expectExceptionMessage($class);

        $target->evaluate($subject);
    }
}
