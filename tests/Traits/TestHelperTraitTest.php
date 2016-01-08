<?php
namespace Narrowspark\TestingHelper\Tests\Traits;

use Mockery as Mock;
use Narrowspark\TestingHelper\Traits\TestHelperTrait;
use Narrowspark\TestingHelper\Tests\Fixture\FooObject;

class TestHelperTraitTest extends \PHPUnit_Framework_TestCase
{
    use TestHelperTrait;

    public function testAssertInArray()
    {
        $haystack = ['Mac', 'NT', 'Irix', 'Linux'];

        $this->assertInArray('Irix', $haystack);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertInArrayToThrowException()
    {
        $haystack = ['Mac', 'NT', 'Irix', 'Linux'];

        $this->assertInArray('mac', $haystack);
    }

    public function testAssertMethodExists()
    {
        $this->assertMethodExists(FooObject::class, 'getPrivateProperty');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertMethodExistsToThrowException()
    {
        $this->assertMethodExists(FooObject::class, 'setPrivateProperty');
    }

    public function testAssertInJson()
    {
        $this->assertInJson('{"test": "true"}', ['test' => 'true']);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertInJsonToThrowException()
    {
        $this->assertInJson('{"test": "false"}', ['test' => 'true']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAssertInJsonToThrowExceptionOnInvalidJson()
    {
        $this->assertInJson('{test: false}', ['test' => 'true']);
    }
}
