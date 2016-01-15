<?php
namespace Narrowspark\TestingHelper\Traits;

use ReflectionClass;

trait AccessTrait
{
    /**
     * Get a private/protected property.
     *
     * @param object|string $object
     * @param string        $propertyName
     *
     * @return mixed
     */
    public function getProperty($object, $propertyName)
    {
        $reflected = new ReflectionClass($object);

        $property = $reflected->getProperty($propertyName);
        $property->setAccessible(true);

        $object = is_string($object) ? new $object() : $object;

        return $property->getValue($object);
    }

    /**
     * Set a non-public member of an object or class
     *
     * @param object|string $object
     * @param string        $propertyName
     * @param mixed         $value
     */
    protected function setProperty($object, $propertyName, $value)
    {
        $reflected = new ReflectionClass($object);

        $property = $reflected->getProperty($propertyName);
        $property->setAccessible(true);

        $object = is_string($object) ? new $object() : $object;

        $property->setValue($object, $value);
    }

    /**
     * Call private and protected methods on an object
     *
     * @param object|string $object
     * @param string        $methodName
     * @param array         $args
     *
     * @return mixed
     */
    protected function callMethod($object, $methodName, array $args = [])
    {
        $class = new ReflectionClass($object);

        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        $object = is_string($object) ? new $object() : $object;

        return $method->invokeArgs($object, $args);
    }
}
