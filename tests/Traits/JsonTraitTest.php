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

use Narrowspark\TestingHelper\Traits\AssertJsonTrait;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @small
 */
final class JsonTraitTest extends TestCase
{
    use AssertJsonTrait;

    public function testAssertInJson(): void
    {
        $this->assertInJson('{"test": "true"}', ['test' => 'true']);
    }

    public function testAssertInJsonToThrowException(): void
    {
        $this->expectException(ExpectationFailedException::class);

        $this->assertInJson('{"test": "false"}', ['test' => 'true']);
    }

    public function testAssertInJsonToThrowExceptionOnInvalidJson(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->assertInJson('{test: false}', ['test' => 'true']);
    }
}
