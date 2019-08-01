<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Constraint\Traits;

use ArrayObject;
use Traversable;

trait ToArrayTrait
{
    /**
     * @param iterable|mixed[] $other
     *
     * @return mixed[]
     */
    protected function toArray(iterable $other): array
    {
        if (\is_array($other)) {
            return $other;
        }

        if ($other instanceof ArrayObject) {
            return $other->getArrayCopy();
        }

        if ($other instanceof Traversable) {
            return \iterator_to_array($other);
        }
        // Keep BC even if we know that array would not be the expected one
        return (array) $other;
    }
}
