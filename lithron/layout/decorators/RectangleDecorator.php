<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RectangleDecorator
 *
 * @author short
 */
class RectangleDecorator implements Decorator {

    public static function wants(Attributes $a) {
        return $a[CSS::_BACKGROUND_COLOR] !== CSS::_TRANSPARENT;
    }

    public static function generate(Attributes $a) {
        return $a[CSS::_BACKGROUND_COLOR];
    }

    public static function render(Renderer $renderer, PrimitiveBox $box, $color) {
        $renderer->save();
        $renderer->setColor("fill", $color);
        $renderer->rect(
            -CSSLayout::calcFrame($box, "BPL"),
            -CSSLayout::calcFrame($box, "BPB"),
            $box[CSS::_WIDTH] + CSSLayout::calcFrame($box, "BPH"),
            $box[CSS::_HEIGHT] + CSSLayout::calcFrame($box, "BPV")
        );
        $renderer->restore();
    }
    
}
?>
