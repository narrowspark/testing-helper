<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Phpunit;

use Mockery as Mock;
use Narrowspark\TestingHelper\Phpunit\MockeryTestCase;
use Narrowspark\TestingHelper\Tests\Fixture\FooObject;

class MockeryTestCaseTest extends MockeryTestCase
{
    public function testAllowMockingNonExistentMethods()
    {
        self::assertFalse(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());

        $this->allowMockingNonExistentMethods(true);

        self::assertTrue(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());
    }

    public function testMock()
    {
        $mocked = $this->mock(FooObject::class);

        self::assertInstanceOf(get_class($mocked), $mocked);
    }
}
