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
        static::assertFalse(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());

        $this->allowMockingNonExistentMethods(true);

        static::assertTrue(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());
    }

    public function testMock(): void
    {
        $mocked = $this->mock(FooObject::class);

        static::assertInstanceOf(\get_class($mocked), $mocked);
    }
}
