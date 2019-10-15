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

use DateTime;

trait AssertDateTrait
{
    /**
     * Compares two dates for equality.
     *
     * @param \DateTime|string $expected
     * @param \DateTime        $actual
     *
     * @return void
     */
    public static function assertSameDate($expected, DateTime $actual): void
    {
        if (! $expected instanceof DateTime) {
            $expected = new DateTime($expected, $actual->getTimezone());
        }

        self::assertInstanceOf(\get_class($expected), $actual);
        self::assertSame($expected->getTimezone()->getName(), $actual->getTimezone()->getName());
        self::assertSame($expected->format('Y-m-d H:i:s'), $actual->format('Y-m-d H:i:s'));
    }

    /**
     * Compares two dates for equality.
     *
     * @param \DateTime|string $expected
     * @param \DateTime        $actual
     *
     * @return void
     */
    public static function assertNotSameDate($expected, DateTime $actual): void
    {
        if (! $expected instanceof DateTime) {
            $expected = new DateTime($expected, $actual->getTimezone());
        }

        self::assertInstanceOf(\get_class($expected), $actual);
        self::assertNotSame($expected, $actual);
    }
}
