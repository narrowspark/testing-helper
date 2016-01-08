<?php
namespace Narrowspark\TestingHelper\Traits;

use InvalidArgumentException;

trait TestHelperTrait
{
    use MockeryTrait;

    /**
     * Setup the test case.
     */
    public function setUp()
    {
        parent::setUp();

        $this->start();
    }

    /**
     * Run extra setup code.
     */
    protected function start()
    {
        // call more setup methods
    }

    /**
     * Tear down the test case.
     */
    public function tearDown()
    {
        $this->finish();

        parent::tearDown();
    }

    /**
     * Run extra tear down code.
     */
    protected function finish()
    {
        // call more tear down methods
    }

    /**
     * Assert that the element exists in the array.
     *
     * @param mixed  $needle
     * @param array  $haystack
     * @param string $message
     */
    public function assertInArray($needle, $haystack, $message = '')
    {
        if ($message === '') {
            $message = "Expected the array to contain the element '$needle'.";
        }

        $this->assertTrue(in_array($needle, $haystack, true), $message);
    }

    /**
     * Assert that the specified method exists on the class.
     *
     * @param string $class
     * @param string $method
     * @param string $message
     */
    public function assertMethodExists($class, $method, $message = '')
    {
        if ($message === '') {
            $message = "Expected the class '$class' to have method '$method'.";
        }

        $this->assertTrue(method_exists($class, $method), $message);
    }

    /**
     * Assert that the element exists in the json.
     *
     * @param string $needle
     * @param array  $haystack
     * @param string $message
     *
     * @throws \InvalidArgumentException
     */
    public function assertInJson($needle, array $haystack, $message = '')
    {
        if ($message === '') {
            $message = "Expected the array to contain the element '$needle'.";
        }

        $array = json_decode($needle, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid json provided: '$needle'.");
        }

        $this->assertArraySubset($haystack, $array, false, $message);
    }
}
