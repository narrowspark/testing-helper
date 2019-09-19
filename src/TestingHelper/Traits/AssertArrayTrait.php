<?php

declare(strict_types=1);

namespace Narrowspark\TestingHelper\Traits;

use ArrayAccess;
use Narrowspark\TestingHelper\Constraint\ArraySubset;
use PHPUnit\Framework\Assert as PhpUnitAssert;
use PHPUnit\Util\InvalidArgumentHelper;

trait AssertArrayTrait
{
    /**
     * Asserts that an array has a specified subset.
     *
     * @param array|ArrayAccess|mixed[] $subset
     * @param array|ArrayAccess|mixed[] $array
     * @param bool                      $checkForObjectIdentity
     * @param string                    $message
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Exception
     */
    public static function assertArraySubset(
        $subset,
        $array,
        bool $checkForObjectIdentity = false,
        string $message = ''
    ): void {
        if (! (\is_array($subset) || $subset instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(
                1,
                'array or ArrayAccess'
            );
        }

        if (! (\is_array($array) || $array instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(
                2,
                'array or ArrayAccess'
            );
        }

        $constraint = new ArraySubset($subset, $checkForObjectIdentity);

        PhpUnitAssert::assertThat($array, $constraint, $message);
    }

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
            $message = "Expected the array to contain the element '{$needle}'.";
        }

        self::assertContains($needle, $haystack, $message);
    }
}
