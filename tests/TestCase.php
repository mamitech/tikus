<?php

namespace Tests;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function getNonPublicMethodFromClass($className, $classMethod)
    {
        $reflector = new \ReflectionClass($className);

        $dummyMethod = $reflector->getMethod($classMethod);
        $dummyMethod->setAccessible(true);

        return $dummyMethod;
    }

    /**
     *  Call a non public method $classMethod from $className with $args and return the result.
     *
     *  @param object $class/Name of class which owned the method
     *  @param string $classMethod Name of the method in the class
     *  @param array $args Arguments to pass to method
     *
     *  @return mixed
     */
    public function callNonPublicMethod($class, string $classMethod, array $args)
    {
        $method = $this->getNonPublicMethodFromClass($class, $classMethod);

        $object = !is_object($class) ? $this->app->make($class) : $class;

        return $method->invokeArgs($object, $args);
    }

    /**
     *  Call a static non public method $classMethod from $className with $args and return the result.
     *
     *  @param string $className Name of the class the method belongs to
     *  @param string $classMethod Name of the method in the class
     *  @param array $args Arguments to pass to method
     *
     *  @return mixed
     */
    public function callStaticNonPublicMethod(string $className, string $classMethod, array $args)
    {
        $method = $this->getNonPublicMethodFromClass($className, $classMethod);

        return $method->invokeArgs(null, $args);
    }

    public function getNonPublicAttributeFromClass($attributeName, $classObject)
    {
        $reflector = new \ReflectionObject($classObject);

        $attribute = $reflector->getProperty($attributeName);
        $attribute->setAccessible(true);

        return $attribute->getValue($classObject);
    }
}
