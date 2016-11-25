<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Fixture;

class FooObject
{
    public static $staticProperty = 'foobar';

    public $property = 'barfoo';

    protected $privateProperty = 'foofoo';

    protected function getPrivateProperty($arg = null)
    {
        return $arg ?: $this->privateProperty;
    }
}
