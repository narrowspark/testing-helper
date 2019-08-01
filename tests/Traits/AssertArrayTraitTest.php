<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Traits;

use Narrowspark\TestingHelper\Traits\AssertArrayTrait;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AssertArrayTraitTest extends TestCase
{
    use AssertArrayTrait;

    public function testAssertInArray(): void
    {
        $haystack = ['Mac', 'NT', 'Irix', 'Linux'];

        $this->assertInArray('Irix', $haystack);
    }

    public function testAssertInArrayToThrowException(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $haystack = ['Mac', 'NT', 'Irix', 'Linux'];

        $this->assertInArray('mac', $haystack);
    }

    public function testAssertArraySubsetPassesStrictConfig(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $this->assertArraySubset(['bar' => 0], ['bar' => '0'], true);
    }

    public function testAssertArraySubsetThrowsExceptionForInvalidSubset(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $this->assertArraySubset([6, 7], [1, 2, 3, 4, 5, 6]);
    }

    public function testAssertArraySubsetThrowsExceptionForInvalidSubsetArgument(): void
    {
        $this->expectException(Exception::class);

        $this->assertArraySubset('string', '');
    }

    public function testAssertArraySubsetThrowsExceptionForInvalidArrayArgument(): void
    {
        $this->expectException(Exception::class);

        $this->assertArraySubset([], '');
    }

    public function testAssertArraySubsetDoesNothingForValidScenario(): void
    {
        $this->assertArraySubset([1, 2], [1, 2, 3]);
    }
}