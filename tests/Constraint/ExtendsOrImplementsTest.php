<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Unit\Constraint;

use Narrowspark\TestingHelper\Constraint\ExtendsOrImplements;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ExtendsOrImplementsTest extends TestCase
{
    public function testCountReturnsExpectedValue(): void
    {
        $target = new ExtendsOrImplements(['one', 'two', 'three']);

        $this->assertEquals(3, $target->count());
    }

    public function testToStringReturnsExpectedValue(): void
    {
        $target = new ExtendsOrImplements();

        $this->assertEquals('extends or implements required classes and interfaces', $target->toString());
    }

    public function testEvaluateReturnsTrueIfClassesAreImplemented(): void
    {
        $subject = new class() extends \ArrayObject {
        };

        $target = new ExtendsOrImplements([\ArrayObject::class]);

        $this->assertTrue($target->evaluate($subject, '', true));
    }

    public function testEvaluateThrowsExceptionWithCorrectFailureDescription(): void
    {
        $class = new class() extends \ArrayObject {
        };
        $subject = new \ReflectionClass($class);

        $target = new ExtendsOrImplements([\Exception::class, \ArrayObject::class]);

        try {
            $target->evaluate($subject);
            $this->fail('Expected exception of type ' . ExpectationFailedException::class . ' but none was thrown.');
        } catch (ExpectationFailedException $e) {
            $message = $e->getMessage();

            $this->assertStringContainsString('+ ' . \ArrayObject::class, $message);
            $this->assertStringContainsString('- ' . \Exception::class, $message);
        }
    }

    public function testEvaluateThrowsExceptionWithCorrectDescriptionFromObject(): void
    {
        $class = new class() extends \ArrayObject {
        };
        $target = new ExtendsOrImplements([\Exception::class]);

        $this->expectException(\PHPUnit\Framework\Exception::class);
        $this->expectExceptionMessage(\get_class($class));

        $target->evaluate($class);
    }

    public function testEvaluateThrowsExceptionWithCorrectDescriptionFromString(): void
    {
        $subject = new class() extends \ArrayObject {
        };
        $class  = \get_class($subject);
        $target = new ExtendsOrImplements([\Exception::class]);

        $this->expectException(\PHPUnit\Framework\Exception::class);
        $this->expectExceptionMessage($class);

        $target->evaluate($class);
    }
}
