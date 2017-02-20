<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Phpunit;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as Mock;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

abstract class MockeryTestCase extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        parent::setUp();

        $this->allowMockingNonExistentMethods(true);
    }

    /**
     * Call allowMockingNonExistentMethods() on setUp().
     *
     * @param bool $allow enable/Disable to mock non existent methods
     */
    public function allowMockingNonExistentMethods($allow = false)
    {
        //Disable mocking of non existent methods.
        $config = Mock::getConfiguration();

        $config->allowMockingNonExistentMethods($allow);
    }

    /**
     * Get a mocked object.
     *
     * @param array $argv
     *
     * @return \Mockery\MockInterface
     */
    protected function mock(...$argv): MockInterface
    {
        return call_user_func_array([Mock::getContainer(), 'mock'], $argv);
    }
}
