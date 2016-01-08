<?php
namespace Narrowspark\TestingHelper\Traits;

use Mockery as Mock;

trait MockeryTrait
{
    protected $allowMockingNonExistentMethods = false;

    public function setUp()
    {
        parent::setUp();

        $config = Mock::getConfiguration();

        //Disable mocking of non existent methods.
        $config->allowMockingNonExistentMethods($this->allowMockingNonExistentMethods);
    }

    public function tearDown()
    {
        parent::tearDown();

        // Verify Mockery expectations.
        Mock::close();
    }

    /**
     * @return \Mockery\MockInterface
     */
    protected function mock()
    {
        $args = func_get_args();

        return call_user_func_array([Mock::getContainer(), 'mock'], $args);
    }

    /**
     * Performs assertions shared by all tests of a test case. This method is
     * called before execution of a test ends and before the tearDown method.
     */
    protected function assertPostConditions()
    {
        parent::assertPostConditions();

        // Add Mockery expectations to assertion count.
        if (($container = Mock::getContainer()) !== null) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }
    }
}
