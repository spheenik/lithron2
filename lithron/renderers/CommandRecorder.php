<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommandRecorder
 *
 * @author short
 */
 
class CommandRecorder {

    public $pdf;
    public $dump = array();

    private $indent = 0;

    public function __construct() {
        $this->pdf = new PDFlib();
    }

    public function __call($func, $params) {

        if ($func == "restore")
            $this->indent--;

        $str = str_repeat("    ", $this->indent);
        $str .= $func;
        $str .= "(";

        foreach($params as $key => $param) {
            if ($key != 0)
                $str .= ", ";
            if (is_string($param))
                $str .= "'".$param."'";
            else if (is_float($param))
                    $str .= sprintf("%.02f", $param);
                else
                    $str .= $param;
        }

        $str .= ")";

        if ($func == "save")
            $this->indent++;

        try {
            $ret = call_user_func_array(array($this->pdf, $func), $params);
        } catch (PDFlibException $e) {
            echo $func;
            throw $e;
        }

        $str .= " = ".$ret;
        $this->dump[] = $str;
        //echo $str."<br/>";
        return $ret;
    }

}
?>
