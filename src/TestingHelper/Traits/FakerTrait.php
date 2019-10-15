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

use Faker\Factory;
use Faker\Generator;

trait FakerTrait
{
    private static $fakers = [];

    /**
     * You get always the same generated data.
     *
     * @param string $locale
     *
     * @return \Faker\Generator
     */
    public function getFaker(string $locale = 'en_US'): Generator
    {
        if (! \array_key_exists($locale, self::$fakers)) {
            $faker = Factory::create();

            $faker->seed(9000);

            self::$fakers[$locale] = $faker;
        }

        return self::$fakers[$locale];
    }
}
