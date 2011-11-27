<?php

class Vector {

    const INFINITY = 1E100;
    const EPSILON  = 1E-4;

    public static function dump($vector) {
        $r = array();
        foreach($vector as $v)
            $r[] = $v === null ? "-" : ($v == 0 ? "0" : sprintf("%.2f", $v));
        return "[".implode("/", $r)."]";
    }

    public static function dumpFrame($frame, $which) {
        switch ($which) {
            case "M" : $idx = 0; break;
            case "B" : $idx = 1; break;
            case "P" : $idx = 2; break;
            default : throw new LithronException("Illegal argument for dumpFrame(): only M, B, or P allowed.");
        }
        $toDump = array();
        for ($i = 0; $i < 4; $i++)
            $toDump[] = $frame[CSSLayout::$frameProps[$i][$idx]];
            
        return self::dump($toDump);
    }

    public static function dumpPos($frame) {
        $toDump[] = $frame[CSS::_TOP];
        $toDump[] = $frame[CSS::_RIGHT];
        $toDump[] = $frame[CSS::_BOTTOM];
        $toDump[] = $frame[CSS::_LEFT];
        return self::dump($toDump);
    }

}

?>