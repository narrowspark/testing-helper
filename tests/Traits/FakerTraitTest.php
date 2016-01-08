<?php
namespace Narrowspark\TestingHelper\Tests\Traits;

use DateTime;
use Narrowspark\TestingHelper\Traits\FakerTrait;

class FakerTraitTest extends \PHPUnit_Framework_TestCase
{
    use FakerTrait;

    public function testGetFaker()
    {
        $faker = $this->getFaker();

        $this->assertInstanceOf('\Faker\Generator', $faker);
        $this->assertSame('Miss Lorna Dibbert', $faker->name);
    }
}
