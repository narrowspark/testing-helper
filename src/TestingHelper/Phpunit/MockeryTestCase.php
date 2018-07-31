<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Phpunit;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as Mock;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
abstract class MockeryTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Performs assertions shared by all tests of a test case.
     *
     * This method is called before the execution of a test starts
     * and after setUp() is called.
     */
    protected function assertPreConditions(): void
    {
        parent::assertPreConditions();

        $this->allowMockingNonExistentMethods();
    }

    /**
     * Call allowMockingNonExistentMethods() on setUp().
     *
     * @param bool $allow enable/disable to mock non existent methods
     */
    protected function allowMockingNonExistentMethods(bool $allow = false): void
    {
        //Disable mocking of non existent methods.
        $config = Mock::getConfiguration();

        $config->allowMockingNonExistentMethods($allow);
    }

    /**
     * Get a mocked object.
     *
     * @param array<int, array> $argv
     *
     * @return \Mockery\MockInterface
     */
    protected function mock(...$argv): MockInterface
    {
        return \call_user_func_array([Mock::getContainer(), 'mock'], $argv);
    }
}
