<?php

declare(strict_types=1);

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
