<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Phpunit;

use Mockery as Mock;
use Narrowspark\TestingHelper\Tests\Fixture\FooObject;
use Narrowspark\TestingHelper\Traits\MockeryTrait;
use PHPUnit\Framework\TestCase;
use Narrowspark\TestingHelper\Phpunit\MockeryTestCase;

class MockeryTestCaseTest extends MockeryTestCase
{
    public function testSetUp()
    {
        $this->allowMockingNonExistentMethods();

        $this->assertFalse(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());
    }

    public function testTearDown()
    {
        parent::tearDown();

        $this->assertTrue(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());
    }

    public function testMock()
    {
        $mocked = $this->mock(FooObject::class);

        $this->assertInstanceOf(get_class($mocked), $mocked);
    }
}
