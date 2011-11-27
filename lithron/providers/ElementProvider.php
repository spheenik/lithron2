<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ElementProvider extends BaseProvider {

    protected $children = array();

    public function addChild($child) {
        $this->children[] = $child;
    }

    public function accept(ProviderTreeVisitor $visitor) {
        $visitor->visitPre($this);
        foreach ($this->children as $child) {
            $child->accept($visitor);
        }
        return $visitor->visitPost($this);
    }

}

?>
