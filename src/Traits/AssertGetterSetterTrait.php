<?php
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
     * @param object  $object    The entity to test the setter and getter for
     * @param string  $getter    The getter function to call
     * @param string  $default   The expected default value of the getter after initialization,
     *                           or an anonymous function that will do test for default values
     *                           that are not null or scalar
     * @param string  $setter    The setter function to call
     * @param mixed   $value     Value to send to the setter function
     * @param boolean $chainable Sets whether the method should be chainable
     * @param string  $return    The expected result of the getter after setting
     *                           (Used when the set value has been manipulated in some way)
     *
     */
    public function assertGetterSetter(
        $object,
        $getter,
        $default = null,
        $setter = null,
        $value = null,
        $chainable = true,
        $return = null
    ) {
        $args = func_get_args();

        //Assert getter exists
        $this->assertTrue(
            method_exists($object, $getter),
            'Object does not contain the specified getter method "' . $getter . '".'
        );

        //Assert getter is callable
        $this->assertTrue(
            is_callable(array($object, $getter)),
            'Specified getter method "' . $getter . '" is not callable.'
        );

        //Assert default values are correct
        $this->assertSame(
            $default,
            $object->$getter(),
            'Object getter ('.$getter.') did not return the correct default value.'
        );

        if (isset($args[3])) {
            //Assert setter exists
            $this->assertTrue(
                method_exists($object, $setter),
                'Object does not contain the specified setter method "' . $setter . '".'
            );

            //Assert setter is callable
            $this->assertTrue(
                is_callable(array($object, $setter)),
                'Specified setter method "' . $setter . '" is not callable.'
            );

            if (isset($args[5]) && $args[5] !== true) {
                //Assert setter returns null (not chainable)
                $this->assertNull($object->$setter($value), 'Object setter ('.$setter.') should not have a return.');
            } else {
                //Assert setter is chainable
                $this->assertSame($object, $object->$setter($value), 'Object setter ('.$setter.') is not chainable.');
            }
        }

        if (isset($args[3])) {
            //Assert that getter returns the value or the manipulated return value
            $this->assertSame(7 == count($args) ? $return : $value, $object->$getter());
        }
    }

    /**
     * Provides ability to set a value on a property without using a setter or a getter
     *
     * @param object $object   The entity on which to set the default value
     * @param string $property The property of the entity on which to set the default value
     * @param mixed  $default  The value to set the property to
     */
    public function setPropertyDefaultValue($object, $property, $default = null)
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
     * @param array  $calls     Array of calls to execute on the entity.
     * @param mixed  $assertion Function or Method that the calls should be made against
     */
    public function arrayAssertionRunner($object, array $calls, $assertion)
    {
        foreach ($calls as $call) {
            array_unshift($call, $object);
            call_user_func_array($assertion, $call);
        }
    }
}
