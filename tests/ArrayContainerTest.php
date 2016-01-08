<?php
namespace Narrowspark\TestingHelper\Tests;

use Narrowspark\TestingHelper\ArrayContainer;

class ArrayContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetAndHas()
    {
        $container = new ArrayContainer(['bar' => 'foo']);

        $this->assertSame('foo', $container->get('bar'));
        $this->assertTrue($container->has('bar'));

        $container->set('baz', 'bar');

        $this->assertSame('bar', $container->get('baz'));
        $this->assertTrue($container->has('baz'));
    }

    public function testCheckIfContainerHasAInterface()
    {
        $container = new ArrayContainer(['bar' => 'foo']);

        $this->assertInstanceOf('\Interop\Container\ContainerInterface', $container);
    }
}
