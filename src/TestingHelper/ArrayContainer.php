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

namespace Narrowspark\TestingHelper;

use Psr\Container\ContainerInterface;

final class ArrayContainer implements ContainerInterface
{
    /** @var array */
    private $entries;

    /**
     * @param mixed[] $entries
     */
    public function __construct(array $entries)
    {
        $this->entries = $entries;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return $this->entries[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function has($id): bool
    {
        return \array_key_exists($id, $this->entries);
    }

    /**
     * @param string $id
     * @param mixed  $value
     */
    public function set(string $id, $value): void
    {
        $this->entries[$id] = $value;
    }
}
