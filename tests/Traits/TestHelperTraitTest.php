<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Traits;

use Narrowspark\TestingHelper\Tests\Fixture\FooObject;
use Narrowspark\TestingHelper\Traits\TestHelperTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class TestHelperTraitTest extends TestCase
{
    use TestHelperTrait;

    public function testAssertInArray(): void
    {
        $haystack = ['Mac', 'NT', 'Irix', 'Linux'];

        self::assertInArray('Irix', $haystack);
    }

    public function testAssertInArrayToThrowException(): void
    {
        $this->expectException(\PHPUnit\Framework\ExpectationFailedException::class);

        $haystack = ['Mac', 'NT', 'Irix', 'Linux'];

        self::assertInArray('mac', $haystack);
    }

    public function testAssertMethodExists(): void
    {
        self::assertMethodExists(FooObject::class, 'getPrivateProperty');
    }

    public function testAssertMethodExistsToThrowException(): void
    {
        $this->expectException(\PHPUnit\Framework\ExpectationFailedException::class);

        self::assertMethodExists(FooObject::class, 'setPrivateProperty');
    }

    public function testAssertInJson(): void
    {
        self::assertInJson('{"test": "true"}', ['test' => 'true']);
    }

    public function testAssertInJsonToThrowException(): void
    {
        $this->expectException(\PHPUnit\Framework\ExpectationFailedException::class);

        self::assertInJson('{"test": "false"}', ['test' => 'true']);
    }

    public function testAssertInJsonToThrowExceptionOnInvalidJson(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        self::assertInJson('{test: false}', ['test' => 'true']);
    }
}
