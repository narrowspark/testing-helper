<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests;

use Narrowspark\TestingHelper\ArrayContainer;
use PHPUnit\Framework\TestCase;

class ArrayContainerTest extends TestCase
{
    public function testSetGetAndHas()
    {
        $container = new ArrayContainer(['bar' => 'foo']);

        self::assertSame('foo', $container->get('bar'));
        self::assertTrue($container->has('bar'));

        $container->set('baz', 'bar');

        self::assertSame('bar', $container->get('baz'));
        self::assertTrue($container->has('baz'));
    }

    public function testCheckIfContainerHasAInterface()
    {
        $container = new ArrayContainer(['bar' => 'foo']);

        self::assertInstanceOf('\Interop\Container\ContainerInterface', $container);
    }
}
