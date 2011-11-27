<?php

function __autoload($class_name) {
//    echo "load $class_name<br/>";
    require_once $class_name . '.php';
}

set_include_path(
    dirname(__FILE__)."/interfaces:".DIRECTORY_SEPARATOR.
    dirname(__FILE__)."/strategies:".DIRECTORY_SEPARATOR.
    dirname(__FILE__)."/providers:".DIRECTORY_SEPARATOR.
    dirname(__FILE__)."/layout:".DIRECTORY_SEPARATOR.
    dirname(__FILE__)."/layout/decorators:".DIRECTORY_SEPARATOR.
    dirname(__FILE__)."/renderers:".DIRECTORY_SEPARATOR.
    dirname(__FILE__)."/visitors:".DIRECTORY_SEPARATOR.
    dirname(__FILE__)."/css:".DIRECTORY_SEPARATOR.
    dirname(__FILE__)."/css/grammar:".DIRECTORY_SEPARATOR.
    get_include_path());


class Lithron {

    private static $decorators = null;

    public static function loadSource($xml) {
        return new LithronSource(new MemoryLogger(), $xml);
    }

    public static function getDecorators() {
        if (self::$decorators === null) {
            self::$decorators = array();
            $files = scandir(dirname(__FILE__)."/layout/decorators");
            foreach($files as $file)
                if (substr($file, -13) == "Decorator.php")
                    self::$decorators[] = substr($file, 0, -4);
        }
        return self::$decorators;
    }
    
}

?>
