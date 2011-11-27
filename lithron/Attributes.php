<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Attributes
 *
 * @author short
 */
class Attributes implements ArrayAccess {

    protected $cache;
    protected $steward;
    protected $cut;
    protected $fontId;
    protected $specified;
    protected $computed;
    protected $nonCss = array();
    protected $queue = array();

    public function __construct(FontSteward $steward) {
        $this->steward = $steward;
    }

    public function addNonCssAttribute($name, $value) {
        $this->nonCss[$name] = $value;
    }

    public function getNonCssAttribute($name) {
        return isset($this->nonCss[$name]) ? $this->nonCss[$name] : null;
    }

    public function queueAttributes($attrs, $spec) {
        $this->queue[] = array($spec, $attrs);
    }

    public function style($attrs, $parent) {
        $specs = array();
        foreach(array_keys($attrs) as $key)
            $specs[$key] = 0;
        $this->specified = $attrs;
        foreach($this->queue as $entry) {
            list($spec, $attrs) = $entry;
            //var_dump(array_keys($attrs));
            foreach($attrs as $prop => $values) {
                if ($specs[$prop] <= $spec) {
                    $specs[$prop] = $spec;
                    $this->specified[$prop] = $values;
                }
            }
        }
        $this->queue = null;
        for ($run = 0; $run < 2; $run++) {
            foreach($this->specified as $key => $specs) {
                if (isset($this->computed[$key]))
                    continue;
                //var_dump($specs);
                $comp = array();
                foreach($specs as $i => $spec) {
                    if ($spec == CSS::$initials[$key][$i] && (($ret = CSS::$computedInitials[$key][$i]) !== null))
                        $comp[] = $ret;
                    else if (($ret = CSSComputer::compute($this, $parent, $key, $spec)) !== null)
                        $comp[] = $ret;
                }
                //var_dump($comp);
                if (count($comp) == 1)
                    $this->computed[$key] = $comp[0];
                else if (count($comp) != 0)
                    $this->computed[$key] = $comp;
            }
        }

        //var_dump($this->computed);
        return $this->specified;
    }

    public function getFontId() {
        if (isset($this->fontId))
            return $this->fontId;
        $this->fontId = $this->steward->getStewardIdForAttributes($this);
        return $this->fontId;
    }

    public function offsetExists($attr) {
        if ($attr & CSS::SPECIFIED) {
                $attr = $attr & 0x0fffffff;
                return array_key_exists($attr, $this->specified);
        }
        return array_key_exists($attr, $this->computed);
    }

    public function offsetGet($attr) {
        if (!is_integer($attr))
            throw new LithronException("Illegal parameter type for offsetGet '{0}'", $attr);
        if ($attr & CSS::SPECIFIED) {
            $attr = $attr & 0x0fffffff;
            if (!isset($this->specified[$attr]))
                return null;
            return count($this->specified[$attr]) == 1 ? $this->specified[$attr][0] : $this->specified[$attr];
        } else {
            if (!isset($this->computed[$attr]))
                return null;
            return $this->computed[$attr];
        }
    }

    public function offsetSet($attribute, $value) {
        throw new LithronException("Setting properties is not allowed");
    }

    public function offsetUnset($attribute) {
        throw new LithronException("Unsetting properties is not allowed");
    }


}

?>
