<?php
declare(strict_types=1);
namespace Narrowspark\TestingHelper\Traits;

use ReflectionProperty;

trait AssertGetterSetterTrait
{
    /**
     * Asserts an entity's default getter value, setter value return and getter value after setting.
     * If the default value is neither null nor a scalar, you may need a custom default tester.
     * In that case you can pass in an anonymous function that takes three arguments.
     * The first arg to your anonymous function will be $this (the test instance),
     * the second arg will be the entity whose getter/setter is being tested,
     * and the third arg will be the name of the getter method.
     * The default function is responsible for calling the appropriate assert___() method.
     *
     * @param object      $object    The entity to test the setter and getter for
     * @param string      $getter    The getter function to call
     * @param mixed       $default   The expected default value of the getter after initialization,
     *                               or an anonymous function that will do test for default values
     *                               that are not null or scalar
     * @param null|string $setter    The setter function to call
     * @param mixed       $value     Value to send to the setter function
     * @param bool        $chainable Sets whether the method should be chainable
     * @param null|string $return    The expected result of the getter after setting
     *                               (Used when the set value has been manipulated in some way)
     *
     * @return void
     */
    public static function assertGetterSetter(
        $object,
        string $getter,
        $default = null,
        string $setter = null,
        $value = null,
        bool $chainable = true,
        string $return = null
    ): void {
        //Assert getter exists
        self::assertTrue(
            method_exists($object, $getter),
            'Object does not contain the specified getter method "' . $getter . '".'
        );

        //Assert getter is callable
        self::assertInternalType(
            'callable',
            [$object, $getter],
            'Specified getter method "' . $getter . '" is not callable.'
        );

        //Assert default values are correct
        self::assertSame(
            $default,
            $object->$getter(),
            'Object getter (' . $getter . ') did not return the correct default value.'
        );

        if ($setter !== null) {
            //Assert setter exists
            self::assertTrue(
                method_exists($object, $setter),
                'Object does not contain the specified setter method "' . $setter . '".'
            );

            //Assert setter is callable
            self::assertInternalType(
                'callable',
                [$object, $setter],
                'Specified setter method "' . $setter . '" is not callable.'
            );

            if ($chainable !== true) {
                //Assert setter returns null (not chainable)
                self::assertNull(
                    $object->$setter($value),
                    'Object setter (' . $setter . ') should not have a return.'
                );
            } else {
                //Assert setter is chainable
                self::assertSame(
                    $object,
                    $object->$setter($value),
                    'Object setter (' . $setter . ') is not chainable.'
                );
            }
        }

        if ($default !== null) {
            //Assert that getter returns the value or the manipulated return value
            self::assertSame(7 == count(func_get_args()) ? $return : $value, $object->$getter());
        }
    }

    /**
     * Provides ability to set a value on a property without using a setter or a getter.
     *
     * @param object $object   The entity on which to set the default value
     * @param string $property The property of the entity on which to set the default value
     * @param mixed  $default  The value to set the property to
     *
     * @return void
     */
    public static function setPropertyDefaultValue($object, string $property, $default = null): void
    {
        $property = new ReflectionProperty($object, $property);

        if ($property->isProtected() || $property->isPrivate()) {
            $property->setAccessible(true);
        }

        $property->setValue($object, $default);
    }

    /**
     * Convenience method that accepts an entity and an array of parameters to test.
     * Runs the calls against the provided method.
     *
     * @param object $object    The entity to execute the tests against
     * @param array  $calls     array of calls to execute on the entity
     * @param mixed  $assertion Function or Method that the calls should be made against
     *
     * @return void
     */
    public static function arrayAssertionRunner($object, array $calls, $assertion): void
    {
        foreach ($calls as $call) {
            array_unshift($call, $object);
            call_user_func_array($assertion, $call);
        }
    }
}
