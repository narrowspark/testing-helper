<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper;

use Psr\Container\ContainerInterface;

class ArrayContainer implements ContainerInterface
{
    private $entries = [];

    public function __construct(array $entries = [])
    {
        $this->entries = $entries;
    }

    public function get($id)
    {
        return $this->entries[$id];
    }

    public function has($id): bool
    {
        return array_key_exists($id, $this->entries);
    }

    public function set($id, $value): void
    {
        $this->entries[$id] = $value;
    }
}
