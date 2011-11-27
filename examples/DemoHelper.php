<?php

class DemoHelper
{

    static public function getBlindText($length = 100)
    {
        $words = array("sequitur", "sed", "erat", "claritatem", "ut", "te");

        $string = "";
        while (strlen($string) <= $length)
        {
            $string .= $words[array_rand($words)]." ";
        }

        return $string;
    }

    static public function getArray($count = 1)
    {
        for($i=0; $i<$count; $i++)
        {
            $array[] = $i;
        }
        return $array;
    }

}

?>