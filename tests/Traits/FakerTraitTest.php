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
    }

    public function testGetFakerReturnsFakerWithDefaultLocale()
    {
        $faker = $this->getFaker('en_US');
        $this->assertInstanceOf('\Faker\Generator', $faker);
        $this->assertSame($faker, $this->getFaker());
    }

    public function testGetFakerReturnsDifferentFakerForDifferentLocale()
    {
        $faker = $this->getFaker('en_US');
        $this->assertInstanceOf('Faker\Generator', $faker);
        $this->assertNotSame($faker, $this->getFaker('de_DE'));
    }

    /**
     * @dataProvider providerLocale
     *
     * @param string $locale
     */
    public function testGetFakerReturnsTheSameInstanceForALocale($locale)
    {
        $faker = $this->getFaker($locale);

        $this->assertInstanceOf('Faker\Generator', $faker);
        $this->assertSame($faker, $this->getFaker($locale));
    }

    /**
     * @return \Generator
     */
    public function providerLocale()
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
