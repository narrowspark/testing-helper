<?php

declare(strict_types=1);

namespace Narrowspark\TestingHelper\Constraint\Traits;

use ArrayObject;

trait ToArrayTrait
{
    /**
     * Transform iterables to array.
     *
     * @param \ArrayObject|iterable|mixed[]|\Traversable $other
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

        return \iterator_to_array($other);
    }
}
