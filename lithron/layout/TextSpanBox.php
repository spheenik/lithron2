<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TextSpanBox
 *
 * @author short
 */
class TextSpanBox extends PrimitiveBox implements Trimmable {

    protected function addDumpAttributes(LayoutDumper $dumper) {
        $dumper->setAttribute("text", html_entity_decode($this->text));
        parent::addDumpAttributes($dumper);
    }

    public function render(Renderer $renderer) {
        $a = $this->provider->getAttributes();
        $renderer->outputText($a, $this->text);
    }

    public function trimLeft() {
        if ($this->lTrim != 0.0) {
            $v = substr($this->text, 1);
            $this->text = $v !== false ? $v : "";
            $this[CSS::_WIDTH] -= $this->lTrim;
        }
    }

    public function trimRight() {
        if ($this->rTrim != 0.0) {
            $v = substr($this->text, 0, -1);
            $this->text = $v !== false ? $v : "";
            $this[CSS::_WIDTH] -= $this->rTrim;
        }
    }

    public function breakable() {
        return $this->breakable;
    }

}
?>
