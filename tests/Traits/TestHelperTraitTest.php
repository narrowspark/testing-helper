<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Traits;

use Narrowspark\TestingHelper\Tests\Fixture\FooObject;
use Narrowspark\TestingHelper\Traits\TestHelperTrait;
use PHPUnit\Framework\TestCase;

class TestHelperTraitTest extends TestCase
{
    use TestHelperTrait;

    public function testAssertInArray()
    {
        $haystack = ['Mac', 'NT', 'Irix', 'Linux'];

        self::assertInArray('Irix', $haystack);
    }

    /**
     * @expectedException \PHPUnit\Framework\ExpectationFailedException
     */
    public function testAssertInArrayToThrowException()
    {
        $haystack = ['Mac', 'NT', 'Irix', 'Linux'];

        self::assertInArray('mac', $haystack);
    }

    public function testAssertMethodExists()
    {
        self::assertMethodExists(FooObject::class, 'getPrivateProperty');
    }

    /**
     * @expectedException \PHPUnit\Framework\ExpectationFailedException
     */
    public function testAssertMethodExistsToThrowException()
    {
        self::assertMethodExists(FooObject::class, 'setPrivateProperty');
    }

    public function testAssertInJson()
    {
        self::assertInJson('{"test": "true"}', ['test' => 'true']);
    }

    /**
     * @expectedException \PHPUnit\Framework\ExpectationFailedException
     */
    public function testAssertInJsonToThrowException()
    {
        self::assertInJson('{"test": "false"}', ['test' => 'true']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAssertInJsonToThrowExceptionOnInvalidJson()
    {
        self::assertInJson('{test: false}', ['test' => 'true']);
    }
}
