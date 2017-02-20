<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Traits;

use DateTime;

trait DateAssertionTrait
{
    /**
     * Compares two dates for equality.
     *
     * @param DateTime|string $expected
     * @param DateTime        $actual
     */
    public function assertSameDate($expected, DateTime $actual)
    {
        if (! $expected instanceof DateTime) {
            $expected = new DateTime($expected, $actual->getTimezone());
        }

        $this->assertInstanceOf(get_class($expected), $actual);

        $this->assertSame($expected->getTimezone()->getName(), $actual->getTimezone()->getName());
        $this->assertSame($expected->format('Y-m-d H:i:s'), $actual->format('Y-m-d H:i:s'));
    }

    /**
     * Compares two dates for equality.
     *
     * @param DateTime|string $expected
     * @param DateTime        $actual
     */
    public function assertNotSameDate($expected, DateTime $actual)
    {
        if (! $expected instanceof DateTime) {
            $expected = new DateTime($expected, $actual->getTimezone());
        }

        $this->assertInstanceOf(get_class($expected), $actual);

        $this->assertNotSame($expected, $actual);
    }
}
