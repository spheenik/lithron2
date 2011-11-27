<?php

class StrategyFactory {

    protected static $strategies = array();

    public static function get($display) {
        if (isset(self::$strategies[$display])) return self::$strategies[$display];
        $class = "";
        $parr = explode("-", $display);
        foreach($parr as $value) $class .= ucfirst($value);
        $class .= "Strategy";
        self::$strategies[$display] = new $class();
        return self::$strategies[$display];
    }
    
}

?>