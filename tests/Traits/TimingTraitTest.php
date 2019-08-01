<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Traits;

use Narrowspark\TestingHelper\Traits\AssertTimingTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class TimingTraitTest extends TestCase
{
    use AssertTimingTrait;

    public function testAssertTiming(): void
    {
        $this->assertTiming(45, static function () {
            return 'yes!';
        });

        $this->assertTiming(
            45,
            static function () {
                return 'yes!';
            },
            10
        );
    }
}
