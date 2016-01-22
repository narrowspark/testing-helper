<?php
namespace Narrowspark\TestingHelper;

use Interop\Container\ContainerInterface;

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

    public function has($id)
    {
        return array_key_exists($id, $this->entries);
    }

    public function set($id, $value)
    {
        $this->entries[$id] = $value;
    }
}