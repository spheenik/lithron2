<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BlockBox
 *
 * @author short
 */
class BlockBox extends CompositeBox {
    
    protected $currentLine = null;
    protected $cursor;

    public function __construct(Provider $provider = null, $frame, $range) {
        parent::__construct($provider, $frame, $range);
        $this->cursor = array(0.0, 0.0);
    }

    protected function addDumpAttributes(LayoutDumper $dumper) {
        if ($this->provider !== null) {
            $dumper->setAttribute("tag", $this->provider->getTagName());
            $a = $this->provider->getAttributes();
            if ($id = $a->getNonCssAttribute("id"))
                $dumper->setAttribute("id", $id);
            if ($class = $a->getNonCssAttribute("class"))
                $dumper->setAttribute("class", $class);
        }
        parent::addDumpAttributes($dumper);
    }

    protected function createNewLineBox() {
        $this->finishOpenLineBox();
        $frame = CSSLayout::frame(array(
            CSS::_MAX_WIDTH => $this->spaceOnNewLine(),
            CSS::_MAX_HEIGHT => min($this[CSS::_HEIGHT] === null ? Vector::INFINITY : $this[CSS::_HEIGHT], $this[CSS::_MAX_HEIGHT]),
        ));
        $this->currentLine = new LineBox(null, $frame, null);
    }

    public function spaceOnCurrentLine() {
        if ($this->currentLine == null)
            return $this->spaceOnNewLine();
        else
            return $this->currentLine->spaceLeft();
    }

    public function spaceOnNewLine() {
        return min($this[CSS::_WIDTH] === null ? Vector::INFINITY : $this[CSS::_WIDTH], $this[CSS::_MAX_WIDTH]);
    }

    public function finishOpenLineBox() {
        if ($this->currentLine === null || $this->currentLine->containsOnlySpace())
            return;
        $this->addChild($this->currentLine);
        $this->currentLine = null;
    }

    public function addChild(PrimitiveBox $child) {
        $child[CSS::_LEFT] += $this->cursor[0];
        $child[CSS::_TOP] += $this->cursor[1];
        $this->cursor[1] += $child[CSS::_HEIGHT] + CSSLayout::calcFrame($child, "MBPV");
        parent::addChild($child);
    }

    public function addInline(PrimitiveBox $inline) {
        if ($this->currentLine == null || !$this->currentLine->canPush($inline)) {
            $this->createNewLineBox();
        }
        $this->currentLine->push($inline);
        if ($inline instanceof LineBreak)
            $this->finishOpenLineBox();
    }

    public function addStaticBlock(PrimitiveBox $block) {
        $this->finishOpenLineBox();
        $this->addChild($block);
    }

    public function addAbsoluteBlock(PrimitiveBox $block) {
        parent::addChild($block);
    }

    public function finalize($parent) {
        $this->finishOpenLineBox();
        foreach($this->children as $child)
            if ($child instanceof LineBox)
                $child->finalize();

        if ($this[CSS::_POSITION] === CSS::_ABSOLUTE)
            CSSLayout::finalizeAbsoluteBlockFrame($this, $parent);
         else
            CSSLayout::finalizeStaticBlockFrame($this, $parent);
    }
    
}
?>
