<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LayoutDumper
 *
 * @author short
 */
class LayoutDumper {

    protected $doc;
    protected $current;

    public static function dump(PrimitiveBox $box) {
        $dumper = new LayoutDumper();
        $box->dump($dumper);
        echo "<pre>".htmlentities($dumper->saveXML())."</pre>";
    }

    private function __construct() {
        $this->doc = new DOMDocument();
        $this->doc->formatOutput = true;
        $this->current = null;
    }

    public function saveXML() {
        return $this->doc->saveXML();
    }

    public function startElement(PrimitiveBox $box, Provider $provider = null) {
        $name = get_class($box);
        $elem = $this->doc->createElement($name);
        if ($this->current === null)
            $this->doc->appendChild($elem);
        else
            $this->current->appendChild($elem);
        $this->current = $elem;
    }

    public function finishElement() {
        $this->current = $this->current->parentNode;
    }

    public function setAttribute($name, $value) {
        $this->current->setAttribute($name, $value);
    }

}
?>
