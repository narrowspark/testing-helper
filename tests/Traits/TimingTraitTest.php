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

namespace Narrowspark\TestingHelper\Tests\Traits;

use Narrowspark\TestingHelper\Traits\AssertTimingTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @small
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
