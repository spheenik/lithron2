<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PDFlibOptionString
 *
 * @author short
 */
class PDFlibOptionString {

    private static function convertParm($parm) {
        if (!is_array($parm))
            $parm = array($parm);
        $result = array();
        foreach($parm as $raw) {
            if (is_bool($raw))
                $cooked = $raw ? "true" : "false";
            else
                $cooked = CSS::toString($raw);
            $result[] = $cooked;
        }
        return implode(" ", $result);
    }

    public static function build() {
        $args = func_get_args();
        $result = array();
        while (count($args)) {
            $result[] = array_shift($args)."={".self::convertParm(array_shift($args))."}";
        }
        return implode(" ", $result);
    }

}
?>
