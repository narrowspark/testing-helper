<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Traits;

use DateTime;
use Narrowspark\TestingHelper\Traits\DateAssertionTrait;
use PHPUnit\Framework\TestCase;

class DateAssertionTraitTest extends TestCase
{
    use DateAssertionTrait;

    public function testAssertSameDate()
    {
        $actual = new DateTime('Wed, 13 Jan 2021 22:23:01 GMT');

        self::assertSameDate(
            'Wed, 13 Jan 2021 22:23:01 GMT',
            $actual
        );
    }

    public function testAssertNotSameDate()
    {
        $actual = new DateTime('Wed, 13 Jan 2021 22:23:01 GMT');

        self::assertNotSameDate(
            'Wed, 13 Jan 2001 22:23:01 GMT',
            $actual
        );
    }
}
