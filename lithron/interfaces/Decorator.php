<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Decorator
 *
 * @author short
 */
interface Decorator {

    public static function wants(Attributes $a);
    public static function generate(Attributes $a);
    public static function render(Renderer $renderer, PrimitiveBox $box, $params);
    
}
?>
