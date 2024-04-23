<?php

namespace tei187\ColorTools\Helpers;

/**
 * Class methods missing from native or required for application.
 */
class ClassMethods {

    /**
     * Checks if the specified object or class has the specified method(s).
     *
     * @param string|string[] $needle The method name(s) to check for.
     * @param object $obj The object or valid namespace to check.
     * @return bool True if the object or class has all the specified methods, false otherwise.
     */
    static public function checkMethods($needle, object $obj): bool
    {
        $methods = get_class_methods($obj);
        $outcome = false;

        switch (gettype($needle)) {
            case "string":
                $outcome = in_array(trim($needle), $methods) !== false ? true : false;
                break;
            case "array":
                $tests = [];
                foreach ($needle as $item) {
                    $tests[] = in_array(trim($item), $methods) !== false ? true : false;
                }
                $outcome = in_array(false, $tests) !== false ? false : true;
                break;
        }
        return $outcome;
    }

    /**
     * Checks if the specified object or class implements the specified interface.
     *
     * @param object|string $obj Object or valid namespace.
     * @param string $interface Full namespace of the interface.
     * @return bool True if the object or class implements the specified interface, false otherwise.
     */
    static function checkForInterface($obj, string $interface): bool
    {
        return in_array($interface, self::get_all_interfaces($obj));
    }

    /**
     * Checks if the specified object or class has the specified trait.
     *
     * @param object|string $obj Object or valid namespace.
     * @param string $trait Name of the trait to check for.
     * @return bool True if the object or class has the specified trait, false otherwise.
     */
    static function checkForTrait($obj, string $trait): bool
    {
        return in_array($trait, self::get_all_traits($obj));
    }

    /**
     * Checks if the given object has the specified parent class.
     *
     * @param object|string $obj The object or class name to check.
     * @param string $parent The parent class name to check for.
     * @return bool True if the object has the specified parent class, false otherwise.
     */
    static function checkForParent($obj, string $parent): bool
    {
        return in_array($parent, self::get_all_parents($obj));
    }

    /**
     * Returns an array of all traits used by the given object or class, including traits used by parent classes.
     *
     * @param object|string $obj The object or class name to get the traits for.
     * @return array An array of trait names.
     */
    static function get_all_traits($obj): array
    {
        $parentClasses = class_parents($obj);
        $traits = class_uses($obj);
        foreach ($parentClasses as $parentClass) {
            $traits = array_merge($traits, class_uses($parentClass));
        }
        return $traits;
    }

    /**
     * Returns an array of all interfaces implemented by the given object or class.
     *
     * @param object|string $obj Object or valid namespace.
     * @return array An array of interface names.
     */
    static function get_all_interfaces($obj): array
    {
        $parentClasses = class_parents($obj);
        $interfaces = class_implements($obj);
        foreach ($parentClasses as $parentClass) {
            $interfaces = array_merge($interfaces, class_implements($parentClass));
        }
        return $interfaces;
    }


    /**
     * Gets all the parent classes of the given object.
     *
     * @param object $obj The object to get the parent classes for.
     * @return string[] An array of all the parent class names.
     */
    static function get_all_parents($obj): array
    {
        $parents = class_parents($obj);
        foreach ($parents as $parentClass) {
            $parents = array_merge($parents, class_parents($parentClass));
        }
        return $parents;
    }
}