<?php
namespace Narrowspark\TestingHelper\Tests\Traits;

use DateInterval;
use DatePeriod;
use DateTime;
use Narrowspark\TestingHelper\Traits\TimingTrait;

class TimingTraitTest extends \PHPUnit_Framework_TestCase
{
    use TimingTrait;

    public function testAssertTiming()
    {
        $this->assertTiming(45, function () {
            return 'yes!';
        });

        $this->assertTiming(
            45,
            function () {
                return 'yes!';
            },
            10
        );
    }
}
