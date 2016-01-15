<?php
namespace Narrowspark\TestingHelper\Traits;

use Faker\Factory;

trait FakerTrait
{
    /**
     * You get always the same generated data.
     *
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        $faker = Factory::create();
        $faker->seed(1234);

        return $faker;
    }
}
