<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AttributesHolderElement
 *
 * @author short
 */
class AttributesHolderElement extends DOMElement  {

    protected $delegate;

    public function init(FontSteward $steward) {
        $this->delegate = new Attributes($steward);
    }

    public function getAttributes() {
        return $this->delegate;
    }

    public function accept(DOMTreeVisitor $visitor) {
        $visitor->visitPre($this);
        $subNode = $this->firstChild;
        while($subNode) {
            if ($subNode instanceof DOMComment)
                continue;
            $subNode->accept($visitor);
            $subNode = $subNode->nextSibling;
        }
        $visitor->visitPost($this);
    }
}

?>
