<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageBox
 *
 * @author short
 */
class PageBox extends BlockBox {

    public function render(Renderer $renderer) {
        $renderer->beginPage($this[CSS::_WIDTH], $this[CSS::_HEIGHT]);
        parent::render($renderer);
        $renderer->endPage();
    }
}
?>
