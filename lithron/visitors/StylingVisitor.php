<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StylingVisitor
 *
 * @author short
 */
class StylingVisitor implements DOMTreeVisitor {

    private $attrStack;

    public function __construct() {
        $this->attrStack = array(array(CSS::$initials, null));
    }

    public function visitPre(DOMNode $node) {
        list($parentSpecified, $parentAobj) = $this->attrStack[count($this->attrStack)-1];
        $myAobj = $node->getAttributes();
        $mySpecified = $myAobj->style($parentSpecified, $parentAobj);
        if ($node->nodeType == XML_ELEMENT_NODE || $myAobj[CSS::_DISPLAY] != CSS::_INLINE) {
            foreach($mySpecified as $prop => $attr)
                if (!in_array($prop, CSS::$inheriteds))
                    $mySpecified[$prop] = CSS::$initials[$prop];
        }
        $this->attrStack[] = array($mySpecified, $myAobj);
    }

    public function visitPost(DOMNode $node) {
        array_pop($this->attrStack);
    }
    
}
?>
