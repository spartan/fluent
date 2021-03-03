<?php

namespace Spartan\Fluent;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Obj Fluent
 *
 * @package Spartan\Fluent
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Obj
{
    /**
     * @param mixed $subject
     * @param mixed $visibility
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function constants($subject, $visibility = null): array
    {
        $visibility = $visibility
            ?: ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE;

        return (new ReflectionClass($subject))->getProperties($visibility);
    }

    /**
     * @param      $subject
     * @param null $visibility
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function properties($subject, $visibility = null): array
    {
        $visibility = $visibility
            ?: ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE;

        return (new ReflectionClass($subject))->getProperties($visibility);
    }

    /**
     * @param      $subject
     * @param null $visibility
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function methods($subject, $visibility = null): array
    {
        $visibility = $visibility
            ?: ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PRIVATE;

        return (new ReflectionClass($subject))->getMethods($visibility);
    }

    /**
     * @param $subject
     *
     * @return object
     */
    public static function safe($subject)
    {
        if ($subject) {
            return $subject;
        }

        return new class {
            public function __call($name, $arguments)
            {
                return null;
            }
        };
    }

    /**
     * @param object|string $className
     *
     * @return string
     */
    public static function classBaseName($className): string
    {
        if (!is_string($className)) {
            $className = get_class($className);
        }

        return substr(strrchr($className, "\\"), 1);
    }

    /**
     * @param object|string $className
     *
     * @return string
     */
    public static function classNameSpace($className): string
    {
        if (!is_string($className)) {
            $className = get_class($className);
        }

        return substr(0, strrchr($className, "\\"));
    }
}
