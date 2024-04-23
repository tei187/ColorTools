<?php

namespace tei187\ColorTools\Dictionaries\DeltaE;

/**
 * Class handling delta E dictionary-based methods.
 */
class Dictionary {
    /**
     * Names of each available class for delta E algorithm.
     * 
     * @var string[]
     */
    const INDEX = [
        'CIE00',
        'CIE76',
        'CIE94',
        'CIEDE2000',
        'CMC_lc',
    ];

    /**
     * Available short-hands for classes of delta E algorithms. Key being shorthand, value being destination class.
     * 
     * @var string[]
     */
    CONST ASSIGNMENT = [
        'ciede00' => 'CIEDE2000',
        'cie2000' => 'CIEDE2000',
        '2000' =>    'CIEDE2000',
        '00' =>      'CIEDE2000',
        '76' =>      'CIE76',
        '94' =>      'CIE94',
        'cmc' =>     'CMC_lc',
        'cmclc' =>   'CMC_lc',
        'cmc-lc' =>  'CMC_lc',
    ];

    /**
     * Tries to asses if passed argument is a reference of available delta E algorithm.
     *
     * @param string $name Name of algorithm.
     * @return string|false Returns class name, if assessed properly. Otherwise, returns boolean false.
     */
    public static function assessDeltaEClass(string $name) {
        $as = "";
        if(is_string($name) && strlen(trim($name)) > 0) {
            $i = array_search(trim($name), self::INDEX);
            if($i === false) {
                $temp = array_map('strtolower', self::INDEX);
                $i = array_search(strtolower(trim($name)), $temp);
                if($i === false) {
                    $i = array_search(strtolower(trim($name)), self::ASSIGNMENT);
                    if($i === false) {
                        return false;
                    } else {
                        $as = self::ASSIGNMENT[$i];
                    }
                } else {
                    $as = self::INDEX[$i];
                }
            } else {
                $as = trim($name);
            }
        }

        return
            $as !== ""
                ? $as
                : false;
    }

    static function index(): array {
        return self::INDEX;
    }
}