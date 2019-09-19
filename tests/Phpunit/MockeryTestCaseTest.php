<?php

declare(strict_types=1);

namespace Narrowspark\TestingHelper\Tests\Phpunit;

use Mockery as Mock;
use Narrowspark\TestingHelper\Phpunit\MockeryTestCase;
use Narrowspark\TestingHelper\Tests\Fixture\FooObject;

/**
 * @internal
 *
 * @small
 */
final class MockeryTestCaseTest extends MockeryTestCase
{
    public function testAllowMockingNonExistentMethods(): void
    {
        self::assertFalse(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());

        $this->allowMockingNonExistentMethods(true);

        self::assertTrue(Mock::getConfiguration()->mockingNonExistentMethodsAllowed());
    }

    public function testMock(): void
    {
        $mocked = $this->mock(FooObject::class);

        self::assertInstanceOf(\get_class($mocked), $mocked);
    }

    public function testSpy(): void
    {
        $spy = $this->spy(FooObject::class);
        $spy->getPrivateProperty();

        $spy->shouldHaveReceived()->getPrivateProperty();
    }

    public function testSpyWithClosure(): void
    {
        $spy = $this->spy(function($n) { return $n + 1;});

        array_map($spy, [1, 2]); // [2, 3]

        $spy->shouldHaveBeenCalled();
        $spy->shouldHaveBeenCalled()->twice();
        $spy->shouldHaveBeenCalled()->with(1)->once();
        $spy->shouldHaveBeenCalled()->with(2)->once();
    }
}
