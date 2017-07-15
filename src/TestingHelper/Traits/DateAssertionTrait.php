<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Traits;

use DateTime;

trait DateAssertionTrait
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

        self::assertInstanceOf(get_class($expected), $actual);

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

        self::assertInstanceOf(get_class($expected), $actual);

        self::assertNotSame($expected, $actual);
    }
}
