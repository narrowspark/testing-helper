<?php

declare(strict_types=1);

/**
 * This file is part of Narrowspark Framework.
 *
 * (c) Daniel Bannert <d.bannert@anolilab.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
