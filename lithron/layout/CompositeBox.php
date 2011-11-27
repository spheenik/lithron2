<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompositeBox
 *
 * @author short
 */
class CompositeBox extends PrimitiveBox {

    public $children = array();

    public function addChild(PrimitiveBox $child) {
        $this->children[] = $child;
    }

    public function dump(LayoutDumper $dumper) {
        $dumper->startElement($this, $this->provider);
        $this->addDumpAttributes($dumper);
        foreach($this->children as $child) {
            $child->dump($dumper);
        }
        $dumper->finishElement();
    }

    public function addAbsoluteBlock(PrimitiveBox $block) {
        $this->addChild($block);
    }

    public function render(Renderer $renderer) {
        $this->renderDecorators($renderer);
        $sorted = array();
        foreach($this->children as $child)
            $sorted[$child[CSS::_Z_INDEX]][] = $child;
        ksort($sorted);
        foreach($sorted as $index)
            foreach($index as $child) {
                $renderer->save();
                $renderer->translate(
                    $child[CSS::_LEFT] + CSSLayout::calcFrame($child, "MBPL"),
                    $this[CSS::_HEIGHT] - $child[CSS::_TOP] - CSSLayout::calcFrame($child, "MBPT") - $child[CSS::_HEIGHT]
                );
                $child->render($renderer);
                $renderer->restore();
            }
    }

}
?>
