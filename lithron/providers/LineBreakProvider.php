<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class LineBreakProvider extends ElementProvider implements PhysicalContent {

    public function getPhysicalContentCount() {
        return 1;
    }

    public function generateBox($frame) {
        $a = $this->getAttributes();
        $lineHeight = $a[CSS::_LINE_HEIGHT];
        $frame[CSS::_WIDTH] = 0;
        $frame[CSS::_HEIGHT] = $lineHeight;
        return new LineBreakBox($this, $frame, $this->range);
    }
}

?>
