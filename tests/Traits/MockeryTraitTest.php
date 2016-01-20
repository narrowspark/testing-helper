<?php
namespace Narrowspark\TestingHelper\Tests\Traits;

use Mockery as Mock;
use Narrowspark\TestingHelper\Tests\Fixture\FooObject;
use Narrowspark\TestingHelper\Traits\MockeryTrait;

class MockeryTraitTest extends \PHPUnit_Framework_TestCase
{
    use MockeryTrait;

    public function testSetUp()
    {
        $this->assertFalse(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());
        $this->assertFalse($this->allowMockingNonExistentMethods());
    }

    public function testTearDown()
    {
        $this->assertFalse(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());

        parent::tearDown();
    }

    public function testMock()
    {
        $mocked = $this->mock(FooObject::class);

        $this->assertInstanceOf('\Mockery_0_Narrowspark_TestingHelper_Tests_Fixture_FooObject', $mocked);
    }
}
