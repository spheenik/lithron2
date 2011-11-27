<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Splitable
 *
 * @author short
 */
interface Splittable {

    public function generateRange($start, BlockBox $container);
}
?>
