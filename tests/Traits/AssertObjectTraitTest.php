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

namespace Narrowspark\TestingHelper\Tests\Traits;

use Narrowspark\TestingHelper\Constraint\ExtendsOrImplements;
use Narrowspark\TestingHelper\Constraint\Traits\ToArrayTrait;
use Narrowspark\TestingHelper\Constraint\UsesTraits;
use Narrowspark\TestingHelper\Tests\Fixture\FooObject;
use Narrowspark\TestingHelper\Traits\AssertObjectTrait;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @small
 */
final class AssertObjectTraitTest extends TestCase
{
    use AssertObjectTrait;
    use ToArrayTrait;

    public function testAssertMethodExists(): void
    {
        $this->assertMethodExists(FooObject::class, 'getPrivateProperty');
    }

    public function testAssertMethodExistsToThrowException(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $this->assertMethodExists(FooObject::class, 'setPrivateProperty');
    }

    public function testAssertPropertyExists(): void
    {
        $this->assertPropertyExists(FooObject::class, 'property');
    }

    public function testAssertPropertyExistsToThrowException(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $this->assertPropertyExists(FooObject::class, 'bat');
    }

    public function testUseTraitAssertMethodCallsAssertThat(): void
    {
        $target = new class() {
            use AssertObjectTrait;

            public static $object;

            public static $constraint;

            public static $message;

            public static function assertThat($object, $constraint, $message = ''): void
            {
                static::$object = $object;
                static::$constraint = $constraint;
                static::$message = $message;
            }
        };

        $usesTraitss = [];
        $message = 'test';
        $object = new \stdClass();

        $target::assertUsesTraits($usesTraitss, $object, $message);

        self::assertSame($object, $target::$object);
        self::assertEquals($message, $target::$message);
        self::assertInstanceOf(UsesTraits::class, $target::$constraint);
    }

    public function testAssertMethodPassesCorrectValueOfTraits(): void
    {
        $target = new class() {
            use AssertObjectTrait;

            public static $traits;

            public static function assertUsesTraits(iterable $usesTraits): UsesTraits
            {
                static::$traits = $usesTraits;

                return new UsesTraits($usesTraits);
            }

            public static function assertThat($object, $constraints, $message = ''): void
            {
            }
        };

        $traits = ['class', 'trait'];

        $target->assertUsesTraits($traits, new \stdClass());
        self::assertEquals($traits, $target::$traits);
    }

    public function testClassAndInterfaceAssertMethodCallsAssertThat(): void
    {
        $target = new class() {
            use AssertObjectTrait;

            public static $object;

            public static $constraint;

            public static $message;

            public static function assertThat($object, $constraint, $message = ''): void
            {
                static::$object = $object;
                static::$constraint = $constraint;
                static::$message = $message;
            }
        };

        $inheritances = [];
        $message = 'test';
        $object = new \stdClass();

        $target::assertInheritance($inheritances, $object, $message);
        self::assertSame($object, $target::$object);
        self::assertEquals($message, $target::$message);
        self::assertInstanceOf(ExtendsOrImplements::class, $target::$constraint);
    }

    public function testAssertMethodPassesCorrectValueOfInheritances(): void
    {
        $target = new class() {
            use AssertObjectTrait;

            public static $inheritances;

            public static function assertInheritance(iterable $parentsAndInterfaces): ExtendsOrImplements
            {
                static::$inheritances = $parentsAndInterfaces;

                return new ExtendsOrImplements($parentsAndInterfaces);
            }

            public static function assertThat($object, $constraints, $message = ''): void
            {
            }
        };

        $inheritances = ['class', 'trait'];

        $target->assertInheritance($inheritances, new \stdClass());
        self::assertEquals($inheritances, $this->toArray($target::$inheritances));
    }
}
