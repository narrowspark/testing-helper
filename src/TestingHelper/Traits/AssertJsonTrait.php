<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Traits;

use Narrowspark\TestingHelper\Constraint\ArraySubset;
use PHPUnit\Framework\Assert as PhpUnitAssert;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

trait AssertJsonTrait
{
    /**
     * Assert that the element exists in the json.
     *
     * @param string $needle
     * @param array  $haystack
     * @param string $message
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Exception
     *
     * @return void
     */
    public static function assertInJson(string $needle, array $haystack, string $message = ''): void
    {
        if ($message === '') {
            $message = "Expected the array to contain the element '{$needle}'.";
        }

        $array = \json_decode($needle, true);

        if (\json_last_error() !== \JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Invalid json provided: '{$needle}'.");
        }

        PhpUnitAssert::assertThat($array, new ArraySubset($haystack), $message);
    }
}
