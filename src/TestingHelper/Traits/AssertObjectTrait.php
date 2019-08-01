<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Traits;

use Narrowspark\TestingHelper\Constraint\ExtendsOrImplements;
use Narrowspark\TestingHelper\Constraint\UsesTraits;

trait AssertObjectTrait
{
    /**
     * Assert that the specified method exists on the class.
     *
     * @param string $class
     * @param string $method
     * @param string $message
     *
     * @return void
     */
    public static function assertMethodExists(string $class, string $method, string $message = ''): void
    {
        if ($message === '') {
            $message = "Expected the class '{$class}' to have method '{$method}'.";
        }

        self::assertTrue(\method_exists($class, $method), $message);
    }

    /**
     * Assert that the specified method exists on the class.
     *
     * @param string $class
     * @param string $property
     * @param string $message
     *
     * @return void
     */
    public static function assertPropertyExists(string $class, string $property, string $message = ''): void
    {
        if ($message === '') {
            $message = "Expected the class '{$class}' to have property '{$property}'.";
        }

        self::assertTrue(\property_exists($class, $property), $message);
    }

    /**
     * Assert that an object extends or implements specific classes resp. interfaces.
     *
     * @param iterable                       $parentsAndInterfaces
     * @param object|\ReflectionClass|string $objectOrClass        The target instance or class name
     * @param string                         $message              failure message
     */
    public static function assertInheritance(iterable $parentsAndInterfaces, $objectOrClass, string $message = ''): void
    {
        static::assertThat($objectOrClass, new ExtendsOrImplements($parentsAndInterfaces), $message);
    }

    /**
     * Asserts that a class uses expected traits.
     *
     * @param iterable      $traits        trait names to check against
     * @param object|string $objectOrClass The target instance or class name
     * @param string        $message       failure message
     */
    public static function assertUsesTraits(iterable $traits, $objectOrClass, string $message = ''): void
    {
        static::assertThat($objectOrClass, new UsesTraits($traits), $message);
    }
}
