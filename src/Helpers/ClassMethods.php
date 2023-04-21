<?php

namespace tei187\ColorTools\Helpers;

/**
 * Class methods missing from native or required for application.
 */
class ClassMethods {
    /**
     * Verifies if listed methods are available in class.
     *
     * @param array|string $needle
     * @param object $obj
     * @return boolean
     */
    static public function checkMethods($needle, object $obj) : bool {
        $methods = get_class_methods($obj);
        $outcome = false;

        switch(gettype($needle)) {
            case "string":
                $outcome = in_array(trim($needle), $methods) !== false ? true : false;
                break;
            case "array":
                $tests = [];
                foreach($needle as $item) {
                    $tests[] = in_array(trim($item), $methods) !== false ? true : false;
                }
                $outcome = in_array(false, $tests) !== false ? false : true;
                break;
        }
        return $outcome;
    }

    static function checkForInterface($obj, string $interface) : bool {
        return in_array($interface, self::get_all_interfaces($obj));
    }

    static function checkForTrait($obj, string $trait) : bool {
        return in_array($trait, self::get_all_traits($obj));
    }

    /**
     * Returns array of all inherited and current traits.
     *
     * @param object|string $obj
     * @return array
     */
    static function get_all_traits($obj) : array {
        $parentClasses = class_parents($obj);
        $traits = class_uses($obj);       
        foreach ($parentClasses as $parentClass) {
            $traits = array_merge($traits, class_uses($parentClass));
        }
        return $traits;
    }

    /**
     * Returns array of all inherited and current interfaces.
     *
     * @param object|string $obj
     * @return array
     */
    static function get_all_interfaces($obj) : array {
        $parentClasses = class_parents($obj);
        $interfaces = class_implements($obj);       
        foreach ($parentClasses as $parentClass) {
            $interfaces = array_merge($interfaces, class_implements($parentClass));
        }
        return $interfaces;
    }
}