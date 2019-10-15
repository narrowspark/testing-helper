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

namespace Narrowspark\TestingHelper\Traits;

trait AssertTimingTrait
{
    /**
     * Assert run time of a callable.
     *
     * @param int      $maxDurationInMs
     * @param callable $callable
     * @param int      $iterations
     *
     * @return void
     */
    public static function assertTiming(int $maxDurationInMs, callable $callable, int $iterations = 20): void
    {
        $duration = 0;

        for ($a = 0; $a < $iterations; $a++) {
            $start = \microtime(true);

            $callable();

            $end = \microtime(true);

            $duration += ($end - $start);
        }

        self::assertLessThanOrEqual($maxDurationInMs, ($duration / $iterations) * 1000);
    }
}
