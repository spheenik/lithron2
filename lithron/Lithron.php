<?php

function __autoload($class_name) {
//    echo "load $class_name<br/>";
    require_once $class_name . '.php';
}

set_include_path(
    dirname(__FILE__)."/interfaces".PATH_SEPARATOR.
    dirname(__FILE__)."/strategies".PATH_SEPARATOR.
    dirname(__FILE__)."/providers".PATH_SEPARATOR.
    dirname(__FILE__)."/layout".PATH_SEPARATOR.
    dirname(__FILE__)."/layout/decorators".PATH_SEPARATOR.
    dirname(__FILE__)."/renderers".PATH_SEPARATOR.
    dirname(__FILE__)."/visitors".PATH_SEPARATOR.
    dirname(__FILE__)."/phathom".PATH_SEPARATOR.
	dirname(__FILE__)."/css".PATH_SEPARATOR.
	get_include_path());

$specPath = ValidationGenerator::generate(array("lithron"), dirname(__FILE__)."/../output");

set_include_path(
	$specPath.PATH_SEPARATOR.
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
