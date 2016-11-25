<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Traits;

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
