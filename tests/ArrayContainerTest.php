<?php

declare(strict_types=1);

/**
 * This file is part of Narrowspark Framework.
 *
 * (c) Daniel Bannert <d.bannert@anolilab.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Narrowspark\TestingHelper\Tests;

use Narrowspark\TestingHelper\ArrayContainer;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @small
 */
final class ArrayContainerTest extends TestCase
{
    public function testSetGetAndHas(): void
    {
        $container = new ArrayContainer(['bar' => 'foo']);

        self::assertSame('foo', $container->get('bar'));
        self::assertTrue($container->has('bar'));

        $container->set('baz', 'bar');

        self::assertSame('bar', $container->get('baz'));
        self::assertTrue($container->has('baz'));
    }

    public function testCheckIfContainerHasAInterface(): void
    {
        $container = new ArrayContainer(['bar' => 'foo']);

        self::assertInstanceOf('\Psr\Container\ContainerInterface', $container);
    }
}
