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

use DateTime;
use Narrowspark\TestingHelper\Traits\AssertDateTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @small
 */
final class AssertDateTraitTest extends TestCase
{
    use AssertDateTrait;

    public function testAssertSameDate(): void
    {
        $actual = new DateTime('Wed, 13 Jan 2021 22:23:01 GMT');

        $this->assertSameDate(
            'Wed, 13 Jan 2021 22:23:01 GMT',
            $actual
        );
    }

    public function testAssertNotSameDate(): void
    {
        $actual = new DateTime('Wed, 13 Jan 2021 22:23:01 GMT');

        $this->assertNotSameDate(
            'Wed, 13 Jan 2001 22:23:01 GMT',
            $actual
        );
    }
}
