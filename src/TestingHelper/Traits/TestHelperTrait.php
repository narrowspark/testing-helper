<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Traits;

use InvalidArgumentException;

trait TestHelperTrait
{
    /**
     * Assert that the element exists in the array.
     *
     * @param mixed  $needle
     * @param array  $haystack
     * @param string $message
     *
     * @return void
     */
    public static function assertInArray($needle, array $haystack, string $message = ''): void
    {
        if ($message === '') {
            $message = "Expected the array to contain the element '$needle'.";
        }

        self::assertTrue(in_array($needle, $haystack, true), $message);
    }

    /**
     * Assert that the specified method exists on the class.
     *
     * @param string $class
     * @param string $method
     * @param string $message
     *
     * @return void
     */
    public static function assertMethodExists(string $class, string $method, string $message = ''): void
    {
        if ($message === '') {
            $message = "Expected the class '$class' to have method '$method'.";
        }

        self::assertTrue(method_exists($class, $method), $message);
    }

    /**
     * Assert that the element exists in the json.
     *
     * @param string $needle
     * @param array  $haystack
     * @param string $message
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public static function assertInJson(string $needle, array $haystack, string $message = ''): void
    {
        if ($message === '') {
            $message = "Expected the array to contain the element '$needle'.";
        }

        $array = json_decode($needle, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid json provided: '$needle'.");
        }

        self::assertArraySubset($haystack, $array, false, $message);
    }
}
