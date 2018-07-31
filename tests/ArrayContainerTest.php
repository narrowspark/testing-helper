<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Tests;

use Narrowspark\TestingHelper\ArrayContainer;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ArrayContainerTest extends TestCase
{
    public function testSetGetAndHas(): void
    {
        $container = new ArrayContainer(['bar' => 'foo']);

        static::assertSame('foo', $container->get('bar'));
        static::assertTrue($container->has('bar'));

        $container->set('baz', 'bar');

        static::assertSame('bar', $container->get('baz'));
        static::assertTrue($container->has('baz'));
    }

    public function testCheckIfContainerHasAInterface(): void
    {
        $container = new ArrayContainer(['bar' => 'foo']);

        static::assertInstanceOf('\Psr\Container\ContainerInterface', $container);
    }
}
