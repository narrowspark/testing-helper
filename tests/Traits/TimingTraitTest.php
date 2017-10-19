<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Traits;

use Narrowspark\TestingHelper\Traits\TimingTrait;
use PHPUnit\Framework\TestCase;

class TimingTraitTest extends TestCase
{
    use TimingTrait;

    public function testAssertTiming(): void
    {
        self::assertTiming(45, function () {
            return 'yes!';
        });

        self::assertTiming(
            45,
            function () {
                return 'yes!';
            },
            10
        );
    }
}
