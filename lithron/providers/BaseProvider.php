<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LithronProvider
 *
 * @author short
 */
abstract class BaseProvider implements Provider {

    protected $rendered = true;
    protected $tagName;
    protected $attributes;
    protected $jobRecorder;
    protected $range;

    public function __construct($tagName, Attributes $attributes, JobRecorder $jobRecorder) {
        $this->tagName = $tagName;
        $this->attributes = $attributes;
        $this->jobRecorder = $jobRecorder;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function getJobRecorder() {
        return $this->jobRecorder;
    }

    public function getTagName() {
        return $this->tagName;
    }

    public function setRange(array $range) {
        $this->range = $range;
    }

    public function getRange()  {
        return $this->range;
    }

    public function getRangeStart() {
        return $this->range[0];
    }

    public function getRangeEnd() {
        return $this->range[1];
    }

    public function setRendered($bool) {
        $this->rendered = $bool;
    }

    public function getRendered() {
        return $this->rendered;
    }

    public function getStrategy() {
        return StrategyFactory::get($this->attributes[CSS::_DISPLAY|CSS::SPECIFIED]->value);
    }

    public function accept(ProviderTreeVisitor $visitor) {
        $visitor->visitPre($this);
        $visitor->visitPost($this);
    }

}

?>
