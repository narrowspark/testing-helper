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

use Narrowspark\TestingHelper\Traits\FakerTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @small
 */
final class FakerTraitTest extends TestCase
{
    use FakerTrait;

    public function testGetFaker(): void
    {
        $faker = $this->getFaker();

        self::assertInstanceOf('\Faker\Generator', $faker);
    }

    public function testGetFakerReturnsFakerWithDefaultLocale(): void
    {
        $faker = $this->getFaker('en_US');

        self::assertInstanceOf('\Faker\Generator', $faker);
        self::assertSame($faker, $this->getFaker());
    }

    public function testGetFakerReturnsDifferentFakerForDifferentLocale(): void
    {
        $faker = $this->getFaker('en_US');

        self::assertInstanceOf('Faker\Generator', $faker);
        self::assertNotSame($faker, $this->getFaker('de_DE'));
    }

    /**
     * @dataProvider provideGetFakerReturnsTheSameInstanceForALocaleCases
     *
     * @param string $locale
     */
    public function testGetFakerReturnsTheSameInstanceForALocale($locale): void
    {
        $faker = $this->getFaker($locale);

        self::assertInstanceOf('Faker\Generator', $faker);
        self::assertSame($faker, $this->getFaker($locale));
    }

    /**
     * @return \Generator
     */
    public function provideGetFakerReturnsTheSameInstanceForALocaleCases(): iterable
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
