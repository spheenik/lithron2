<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LineBox
 *
 * @author short
 */
class LineBox extends CompositeBox {
    protected $lastIsWord;

    public function __construct(Provider $provider = null, $frame, $range) {
        parent::__construct($provider, $frame, $range);
        $this->lastIsWord = false;
        //$this->decorators[] = array("RectangleDecorator", array("rgb", 0.9, 0.9, 0.9, 0));
    }

    public function containsOnlySpace() {
        return count($this->children) == 0;
    }

    public function spaceLeft() {
        $result = $this[CSS::_MAX_WIDTH] - $this[CSS::_WIDTH] + Vector::EPSILON;
        //echo "spaceLeft() ".$result."<br/>";
        return $result;
    }

    public function canPush(PrimitiveBox $box) {
        if ($box instanceof LayoutCommand) return true;
        if ($c = count($this->children)) {
            $last = $this->children[$c-1];
            if ($last instanceof Trimmable && !$last->breakable())
                return true;
        }
        return $this[CSS::_MAX_WIDTH] - $this[CSS::_WIDTH] - $box[CSS::_WIDTH] + Vector::EPSILON >= 0.0;
    }

    public function push(PrimitiveBox $box) {
        if ($box instanceof Trimmable && count($this->children) == 0) {
            $box->trimLeft();
            if ($box[CSS::_WIDTH] == 0.0)
                return;
        }
        $this->addChild($box);
        $this[CSS::_WIDTH] += $box[CSS::_WIDTH];

        $maxDesc = -Vector::INFINITY;
        $maxAsc = -Vector::INFINITY;
        foreach($this->children as $child) {
            $maxDesc = max($child->descender, $maxDesc);
            $maxAsc = max($child[CSS::_HEIGHT]-$child->descender, $maxAsc);
        }
        $this[CSS::_HEIGHT] = $maxAsc + $maxDesc;
    }

    public function finalize() {
        $childCount = count($this->children);
        if ($childCount && $this->children[$childCount-1] instanceof Trimmable)
            $this->children[$childCount-1]->trimRight();
        $maxDesc = -Vector::INFINITY;
        $maxAsc = -Vector::INFINITY;
        foreach($this->children as $child) {
            $maxDesc = max($child->descender, $maxDesc);
            $maxAsc = max($child[CSS::_HEIGHT]-$child->descender, $maxAsc);
        }
        $x = 0.0;
        foreach($this->children as $child) {
            switch($child[CSS::_POSITION]) {
                case CSS::_STATIC:
                    $child[CSS::_LEFT] += $x;
                    $child[CSS::_TOP] += $maxDesc;
                    $x += $child[CSS::_WIDTH];
                    break;
                case CSS::_RELATIVE:
                    $child[CSS::_LEFT] += $x;
                    $child[CSS::_TOP] += $this[CSS::_HEIGHT];
                    break;
                case CSS::_ABSOLUTE:
                    throw new LithronException("Unexpected absolutely positioned element in LineBox.");
            }
        }
        $this[CSS::_WIDTH] = $x;
    }

    public function render(Renderer $renderer) {
        $this->renderDecorators($renderer);
        foreach($this->children as $child) {
            $renderer->save();
            $renderer->translate(
                $child[CSS::_LEFT],
                $child[CSS::_TOP]
            );
            $child->render($renderer);
            $renderer->restore();
        }
    }

}
?>
