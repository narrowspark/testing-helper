<?php
namespace Narrowspark\TestingHelper\Traits;

trait TimingTrait
{
    /**
     * Assert run time of a callable.
     *
     * @param int      $maxDurationInMs
     * @param callable $callable
     * @param int      $iterations
     */
    protected function assertTiming($maxDurationInMs, callable $callable, $iterations = 20)
    {
        $duration = 0;

        for ($a = 0; $a < $iterations; ++$a) {
            $start = microtime(true);

            $callable();

            $end = microtime(true);

            $duration += ($end - $start);
        }

        $this->assertLessThanOrEqual($maxDurationInMs, ($duration / $iterations) * 1000);
    }
}
