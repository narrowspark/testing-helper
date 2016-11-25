<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Traits;

use Faker\Factory;
use Faker\Generator;

trait FakerTrait
{
    private $fakers = [];

    /**
     * You get always the same generated data.
     *
     * @param string $locale
     * @param array  $providers
     *
     * @return \Faker\Generator
     */
    public function getFaker(string $locale = 'en_US', array $providers = []): Generator
    {
        if (! array_key_exists($locale, $this->fakers)) {
            $faker = Factory::create();

            $providers = array_filter($providers);

            if (! empty($providers)) {
                foreach ($providers as $provider) {
                    $faker->addProvider($provider);
                }
            }

            $faker->seed(9000);

            $this->fakers[$locale] = $faker;
        }

        return $this->fakers[$locale];
    }
}
