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

namespace Narrowspark\TestingHelper\Tests\Unit\Constraint;

use ArrayAccessible;
use ArrayObject;
use Countable;
use Narrowspark\TestingHelper\Constraint\ArraySubset;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\SelfDescribing;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use Traversable;

/**
 * @internal
 *
 * @small
 */
final class ArraySubsetTest extends TestCase
{
    /**
     * @return mixed[]
     */
    public static function provideEvaluateCases(): iterable
    {
        return [
            'loose array subset and array other' => [
                'expected' => true,
                'subset' => ['bar' => 0],
                'other' => ['foo' => '', 'bar' => '0'],
                'strict' => false,
            ],
            'strict array subset and array other' => [
                'expected' => false,
                'subset' => ['bar' => 0],
                'other' => ['foo' => '', 'bar' => '0'],
                'strict' => true,
            ],
            'loose array subset and ArrayObject other' => [
                'expected' => true,
                'subset' => ['bar' => 0],
                'other' => new ArrayObject(['foo' => '', 'bar' => '0']),
                'strict' => false,
            ],
            'strict ArrayObject subset and array other' => [
                'expected' => true,
                'subset' => new ArrayObject(['bar' => 0]),
                'other' => ['foo' => '', 'bar' => 0],
                'strict' => true,
            ],
        ];
    }

    /**
     * @param bool                      $expected
     * @param array|mixed[]|Traversable $subset
     * @param array|mixed[]|Traversable $other
     * @param bool                      $strict
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @dataProvider provideEvaluateCases
     */
    public function testEvaluate(bool $expected, $subset, $other, $strict): void
    {
        $constraint = new ArraySubset($subset, $strict);

        self::assertSame($expected, $constraint->evaluate($other, '', true));
    }

    public function testEvaluateWithArrayAccess(): void
    {
        $arrayAccess = new ArrayAccessible(['foo' => 'bar']);

        $constraint = new ArraySubset(['foo' => 'bar']);

        self::assertTrue($constraint->evaluate($arrayAccess, '', true));
    }

    public function testEvaluateFailMessage(): void
    {
        $constraint = new ArraySubset(['foo' => 'bar']);

        try {
            $constraint->evaluate(['baz' => 'bar'], '', false);
            self::fail(\sprintf('Expected %s to be thrown.', ExpectationFailedException::class));
        } catch (ExpectationFailedException $expectedException) {
            $comparisonFailure = $expectedException->getComparisonFailure();

            self::assertNotNull($comparisonFailure);
            self::assertStringContainsString("'foo' => 'bar'", $comparisonFailure->getExpectedAsString());
            self::assertStringContainsString("'baz' => 'bar'", $comparisonFailure->getActualAsString());
        }
    }

    public function testIsCountable(): void
    {
        $reflection = new ReflectionClass(ArraySubset::class);

        self::assertTrue(
            $reflection->implementsInterface(Countable::class),
            \sprintf(
                'Failed to assert that ArraySubset implements "%s".',
                Countable::class
            )
        );
    }

    public function testIsSelfDescribing(): void
    {
        $reflection = new ReflectionClass(ArraySubset::class);

        self::assertTrue(
            $reflection->implementsInterface(SelfDescribing::class),
            \sprintf(
                'Failed to assert that Array implements "%s".',
                SelfDescribing::class
            )
        );
    }
}
