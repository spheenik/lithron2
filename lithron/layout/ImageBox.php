<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageBox
 *
 * @author short
 */
class ImageBox extends PrimitiveBox {

    protected function addDumpAttributes(LayoutDumper $dumper) {
        $a = $this->provider->getAttributes();
        parent::addDumpAttributes($dumper);
        $dumper->setAttribute("file", $this->provider->getAttributes()->getNonCssAttribute("src"));
        $dumper->setAttribute("fitmethod", CSS::toString($a[CSS::_IMAGE_FITMETHOD]));
    }

    public function render(Renderer $renderer) {
        $a = $this->provider->getAttributes();

        $this->renderDecorators($renderer);

        if ($this->isPdf) {
            $renderer->putPDFPage(
                $this->provider->getFileId(),
                $this[CSS::_WIDTH],
                $this[CSS::_HEIGHT],
                $a[CSS::_IMAGE_POSITION],
                $a[CSS::_IMAGE_FITMETHOD],
                $a[CSS::_IMAGE_SCALE]
            );
        } else {
            $renderer->putImage(
                $this->provider->getFileId(),
                $this[CSS::_WIDTH],
                $this[CSS::_HEIGHT],
                $a[CSS::_IMAGE_POSITION],
                $a[CSS::_IMAGE_FITMETHOD],
                $a[CSS::_IMAGE_SCALE]
            );
        }
        //$renderer->translate($this[CSS::_WIDTH], 0.0);
    }

}
?>
