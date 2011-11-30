<?php

function __autoload($class_name) {
//    echo "load $class_name<br/>";
    require_once $class_name . '.php';
}

set_include_path(
    dirname(__FILE__).DIRECTORY_SEPARATOR."interfaces".PATH_SEPARATOR.
    dirname(__FILE__).DIRECTORY_SEPARATOR."strategies".PATH_SEPARATOR.
    dirname(__FILE__).DIRECTORY_SEPARATOR."providers".PATH_SEPARATOR.
    dirname(__FILE__).DIRECTORY_SEPARATOR."layout".PATH_SEPARATOR.
    dirname(__FILE__).DIRECTORY_SEPARATOR."layout".DIRECTORY_SEPARATOR."decorators".PATH_SEPARATOR.
    dirname(__FILE__).DIRECTORY_SEPARATOR."renderers".PATH_SEPARATOR.
    dirname(__FILE__).DIRECTORY_SEPARATOR."visitors".PATH_SEPARATOR.
    dirname(__FILE__).DIRECTORY_SEPARATOR."phathom".PATH_SEPARATOR.
	dirname(__FILE__).DIRECTORY_SEPARATOR."css".PATH_SEPARATOR.
	get_include_path());

class Lithron {

    private static $decorators = null;

    public static function loadSource($xml) {
        return new LithronSource(new MemoryLogger(), $xml);
    }

    public static function getDecorators() {
        if (self::$decorators === null) {
            self::$decorators = array();
            $files = scandir(dirname(__FILE__).DIRECTORY_SEPARATOR."layout".DIRECTORY_SEPARATOR."decorators");
            foreach($files as $file)
                if (substr($file, -13) == "Decorator.php")
                    self::$decorators[] = substr($file, 0, -4);
        }
        return self::$decorators;
    }
    
    public static function getRelativeOutputPath() {
    	return "output";    	
    }
    
    public static function getAbsoluteOutputPath() {
    	return getcwd().DIRECTORY_SEPARATOR."output";
    }
    
    public static function makeDirOrDie($dir) {
    	@mkdir($dir, 0777, true);
    	if (!is_writable($dir))
    	throw new LithronException("Tried to make dir '$dir', but it is not writable.");
    }
}

$specPath = ValidationGenerator::generate(array("lithron"), Lithron::getAbsoluteOutputPath().DIRECTORY_SEPARATOR."css_tree");

set_include_path(
$specPath.PATH_SEPARATOR.
get_include_path());



?>
