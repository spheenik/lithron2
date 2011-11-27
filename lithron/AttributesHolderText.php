<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AttributesHolderText
 *
 * @author short
 */
class AttributesHolderText extends DOMText  {

    protected $delegate;

    public function init(FontSteward $steward) {
        $this->delegate = new Attributes($steward);
    }

    public function getAttributes() {
        return $this->delegate;
    }

    public function accept(DOMTreeVisitor $visitor) {
        $visitor->visitPre($this);
        $visitor->visitPost($this);
    }

}

?>
