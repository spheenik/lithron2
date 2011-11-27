<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Visitor
 *
 * @author short
 */
interface DOMTreeVisitor {

    public function visitPre(DOMNode $node);
    public function visitPost(DOMNode $node);

}
?>
