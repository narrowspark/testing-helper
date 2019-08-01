<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Phpunit;

use Mockery as Mock;
use Narrowspark\TestingHelper\Phpunit\MockeryTestCase;
use Narrowspark\TestingHelper\Tests\Fixture\FooObject;

/**
 * @internal
 */
final class MockeryTestCaseTest extends MockeryTestCase
{
    public function testAllowMockingNonExistentMethods(): void
    {
        $this->assertFalse(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());

        $this->allowMockingNonExistentMethods(true);

        $this->assertTrue(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());
    }

    public function testMock(): void
    {
        $mocked = $this->mock(FooObject::class);

        $this->assertInstanceOf(\get_class($mocked), $mocked);
    }

    public function testSpy(): void
    {
        $spy = $this->spy(FooObject::class);
        $spy->getPrivateProperty();

        $spy->shouldHaveReceived()->getPrivateProperty();
    }
}
