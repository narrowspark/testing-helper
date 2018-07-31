<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Traits;

use Narrowspark\TestingHelper\Traits\FakerTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class FakerTraitTest extends TestCase
{
    use FakerTrait;

    public function testGetFaker(): void
    {
        $faker = self::getFaker();

        static::assertInstanceOf('\Faker\Generator', $faker);
    }

    public function testGetFakerReturnsFakerWithDefaultLocale(): void
    {
        $faker = self::getFaker('en_US');

        static::assertInstanceOf('\Faker\Generator', $faker);
        static::assertSame($faker, self::getFaker());
    }

    public function testGetFakerReturnsDifferentFakerForDifferentLocale(): void
    {
        $faker = self::getFaker('en_US');

        static::assertInstanceOf('Faker\Generator', $faker);
        static::assertNotSame($faker, self::getFaker('de_DE'));
    }

    /**
     * @dataProvider providerLocale
     *
     * @param string $locale
     */
    public function testGetFakerReturnsTheSameInstanceForALocale($locale): void
    {
        $faker = self::getFaker($locale);

        static::assertInstanceOf('Faker\Generator', $faker);
        static::assertSame($faker, self::getFaker($locale));
    }

    /**
     * @return \Generator
     */
    public function providerLocale(): \Generator
    {
        $values = [
            'de_DE',
            'en_US',
            'en_UK',
            'fr_FR',
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }
}
