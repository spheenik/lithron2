<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProviderGenerationVisitor
 *
 * @author short
 */
class ProviderGenerationVisitor implements DOMTreeVisitor {

    private $jobRecorder;
    private $rootProvider;
    private $providerStack;

    public function __construct(JobRecorder $jobRecorder) {
        $this->jobRecorder = $jobRecorder;
        $this->providerStack = null;
    }

    public function getRootProvider() {
        return $this->rootProvider;
    }

    private function instantiateProviderClass($name, $attrs, $jobRecorder, $providerAttribute) {
        $parr = explode("-", $providerAttribute);
        $class = "";
        foreach($parr as $value) $class .= ucfirst($value);
        $class .= "Provider";
        require_once(dirname(__FILE__)."/../providers/".$class.".php");
        return new $class($name, $attrs, $jobRecorder);
    }

    public function visitPre(DOMNode $node) {
        switch($node->nodeType) {
            case XML_ELEMENT_NODE:
                $a = $node->getAttributes();
                $instance = $this->instantiateProviderClass($node->nodeName, $a, $this->jobRecorder, $a[CSS::_PROVIDER|CSS::SPECIFIED]->value);
                break;
            case XML_TEXT_NODE:
                if ($node->nodeValue === "")
                    return;
                $a = $node->getAttributes();
                $instance = $this->instantiateProviderClass(null, $a, $this->jobRecorder, "text");
                //var_dump($node->nodeValue);
                $instance->init($node->nodeValue);
                break;
            default:
                throw new LithronException("Invalid node type " + $node->nodeType);
        }
        if ($this->providerStack === null) {
            $this->rootProvider = $instance;
            $this->providerStack = array();
        }
        $this->providerStack[] = $instance;
    }


    public function visitPost(DOMNode $node) {
        switch($node->nodeType) {
            case XML_TEXT_NODE:
                if ($node->nodeValue === "")
                    return;
            case XML_ELEMENT_NODE:
                $instance = array_pop($this->providerStack);
                if (count($this->providerStack))
                    $this->providerStack[count($this->providerStack)-1]->addChild($instance);
                break;
            default:
                return;
        }
    }

}
?>
