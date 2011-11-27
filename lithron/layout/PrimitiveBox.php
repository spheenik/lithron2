<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrimitiveBox
 *
 * @author short
 */
abstract class PrimitiveBox implements ArrayAccess {

    public $provider;
    protected $decorators = array();
    protected $frame;
    protected $range;

    public $descender = 0.0;
    public $halfLead = 0.0;

    public function __construct(Provider $provider = null, $frame, $range) {
        $this->provider = $provider;
        $this->frame = $frame;
        $this->range = $range;
    }

    public function getRangeStart() {
        return $this->range[0];
    }

    public function getRangeEnd() {
        return $this->range[1];
    }

    public function offsetExists($attr) {
        return array_key_exists($attr, $this->frame);
    }

    public function offsetGet($attr) {
        return $this->frame[$attr];
    }

    public function offsetSet($attr, $value) {
        $this->frame[$attr] = $value;
    }

    public function offsetUnset($attribute) {
        throw new LithronException("Unsetting properties is not allowed");
    }


    protected function addDumpAttributes($dumper) {
//        if ($this->range != null)
//            $dumper->setAttribute("range", Vector::dump($this->range));
        $dumper->setAttribute("pos", Vector::dumpPos($this));
        $dumper->setAttribute("size", Vector::dump(array($this[CSS::_WIDTH], $this[CSS::_HEIGHT])));
        $dumper->setAttribute("min", Vector::dump(array($this[CSS::_MIN_WIDTH], $this[CSS::_MIN_HEIGHT])));
        $dumper->setAttribute("max", Vector::dump(array($this[CSS::_MAX_WIDTH], $this[CSS::_MAX_HEIGHT])));
        foreach(array("M", "B", "P") as $idx)
            $dumper->setAttribute($idx, Vector::dumpFrame($this, $idx));
    }

    public function dump(LayoutDumper $dumper) {
        $dumper->startElement($this, $this->provider);
        $this->addDumpAttributes($dumper);
        $dumper->finishElement();
    }

    public function addDecorators(Attributes $a) {
        $decs = Lithron::getDecorators();
        foreach($decs as $dec)
            if (call_user_func(array($dec, "wants"), $a)) {
                $this->decorators[] = array($dec, call_user_func(array($dec, "generate"), $a));
            }
    }

    public function renderDecorators(Renderer $renderer) {
        foreach($this->decorators as $desc) {
            list($class, $params) = $desc;
            call_user_func(array($class, "render"), $renderer, $this, $params);
        }
    }

    abstract public function render(Renderer $renderer);

    public function finalize() {
        
    }

}

?>
