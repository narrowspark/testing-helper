<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests\Traits;

use Narrowspark\TestingHelper\Tests\Fixture\FooObject;
use Narrowspark\TestingHelper\Traits\AccessTrait;
use PHPUnit\Framework\TestCase;

class AccessTraitTest extends TestCase
{
    use AccessTrait;

    public function testGetProperty()
    {
        $this->assertEquals('foobar', $this->getProperty(new FooObject(), 'staticProperty'));
        $this->assertEquals('barfoo', $this->getProperty(new FooObject(), 'property'));
        $this->assertEquals('foofoo', $this->getProperty(FooObject::class, 'privateProperty'));
    }

    /**
     * @expectedException \ReflectionException
     */
    public function testGetPropertyThrowReflectionException()
    {
        $this->getProperty(new FooObject(), 'ids');
    }

    public function testSetProperty()
    {
        $class = new FooObject();

        $this->setProperty($class, 'staticProperty', 'barfoo');
        $this->setProperty($class, 'property', 'foobar');
        $this->setProperty($class, 'privateProperty', 'foofoobar');

        $this->assertEquals('barfoo', $this->getProperty($class, 'staticProperty'));
        $this->assertEquals('foobar', $this->getProperty($class, 'property'));
        $this->assertEquals('foofoobar', $this->getProperty($class, 'privateProperty'));
    }

    public function testCallMethod()
    {
        $class = new FooObject();

        $this->assertEquals('foofoo', $this->callMethod($class, 'getPrivateProperty'));
        $this->assertEquals('foofoo', $this->callMethod(FooObject::class, 'getPrivateProperty'));
        $this->assertEquals('foo', $this->callMethod($class, 'getPrivateProperty', ['foo']));
    }
}
