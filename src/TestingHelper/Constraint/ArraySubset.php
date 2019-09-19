<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Constraint;

use Narrowspark\TestingHelper\Constraint\Traits\ToArrayTrait;
use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\IsEqual;
use PHPUnit\Framework\Constraint\IsIdentical;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * Constraint that asserts that the array it is evaluated for has a specified subset.
 *
 * Uses array_replace_recursive() to check if a key value subset is part of the
 * subject array.
 */
final class ArraySubset extends Constraint
{
    use ToArrayTrait;

    /** @var mixed[] */
    private $subset;

    /** @var bool */
    private $strict;

    /**
     * @param mixed[] $subset
     * @param bool    $strict
     */
    public function __construct(iterable $subset, bool $strict = false)
    {
        $this->strict = $strict;
        $this->subset = $this->toArray($subset);
    }

    /**
     * Evaluates the constraint for parameter $other.
     *
     * If $returnResult is set to false (the default), an exception is thrown
     * in case of a failure. null is returned otherwise.
     *
     * If $returnResult is true, the result of the evaluation is returned as
     * a boolean value instead: true in case of success, false in case of a
     * failure.
     *
     * @param iterable|mixed[]|mixed $other
     * @param string                 $description
     * @param bool                   $returnResult
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     *
     * @return bool|null
     */
    public function evaluate($other, string $description = '', bool $returnResult = false): ?bool
    {
        //type cast $other & $this->subset as an array to allow
        //support in standard array functions.
        $arr     = $this->toArray($other);
        $patched = \array_replace_recursive($arr, $this->subset);

        if ($this->strict) {
            $result = (new IsIdentical($patched))->evaluate($arr, '', true);
        } else {
            $result = (new IsEqual($patched))->evaluate($arr, '', true);
        }

        if ($returnResult) {
            return $result;
        }

        if ($result) {
            return null;
        }

        $f = new ComparisonFailure(
            $patched,
            $arr,
            \var_export($patched, true),
            \var_export($arr, true)
        );

        $this->fail($arr, $description, $f);

        return null;
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @throws InvalidArgumentException
     */
    public function toString(): string
    {
        return 'has the subset ' . $this->exporter()->export($this->subset);
    }

    /**
     * Returns the description of the failure.
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * @param mixed $other evaluated value or object
     *
     * @throws InvalidArgumentException
     */
    protected function failureDescription($other): string
    {
        return 'an array ' . $this->toString();
    }
}
