<?php
namespace Narrowspark\TestingHelper\Traits;

use Faker\Factory;

trait FakerTrait
{
    private $fakers = [];

    /**
     * You get always the same generated data.
     *
     * @return \Faker\Generator
     */
    public function getFaker($locale = 'en_US', array $providers = [])
    {
        if (!array_key_exists($locale, $this->fakers)) {
            $faker = Factory::create();

            $providers = array_filter($providers);

            if (!empty($providers)) {
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
