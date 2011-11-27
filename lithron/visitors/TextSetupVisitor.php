<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TextSetupVisitor
 *
 * @author short
 */
class TextSetupVisitor implements DOMTreeVisitor {

    private $carryStack = array();
    private $n = -1;


    private function basicTrim(DOMNode $node) {
        $a = $node->getAttributes();
        $v = $node->nodeValue;
        switch($a[CSS::_TEXT_TRANSFORM]) {
            case CSS::_UPPERCASE_SZ:
                    $v = str_replace("ß", "ss", $v);
                    // break left intentionally
            case CSS::_UPPERCASE:
                    $v = mb_convert_case($v, MB_CASE_UPPER, "UTF-8");
                    break;
            case CSS::_LOWERCASE:
                    $v = mb_convert_case($v, MB_CASE_LOWER, "UTF-8");
                    break;
            case CSS::_CAPITALIZE:
                    $v = mb_convert_case($v, MB_CASE_TITLE, "UTF-8");
                    break;
        }

        $w = $a[CSS::_WHITE_SPACE];
        switch($w) {
            case CSS::_NORMAL:
            case CSS::_NOWRAP:
            case CSS::_PRE_LINE:
                $v = preg_replace('/[\t\r ]*\n[\t\r ]*/', "\n", $v);
        }
        switch($w) {
            case CSS::_PRE:
            case CSS::_PRE_WRAP:
                $v = preg_replace('/[ ]/', "&#32;", $v);
        }


        switch($w) {
            case CSS::_NORMAL:
            case CSS::_NOWRAP:
                $v = preg_replace('/\n/', " ", $v);
        }
        switch($w) {
            case CSS::_NORMAL:
            case CSS::_NOWRAP:
            case CSS::_PRE_LINE:
                $v = preg_replace('/[\t ]+/', " ", $v);
        }
        return $v;
    }

    private function isContext(DOMNode $node) {
        $a = $node->getAttributes();
        return in_array($a[CSS::_DISPLAY], array(CSS::_PAGE, CSS::_BLOCK));
    }

    public function visitPre(DOMNode $node) {
        if ($this->isContext($node)) {
            $this->carryStack[] = true;
            $this->n++;
        }
        if ($node->nodeType !== XML_TEXT_NODE) {
            $a = $node->getAttributes();
            if (!in_array($a[CSS::_PROVIDER], array(CSS::_ELEMENT, CSS::_LINE_BREAK))) {
                //echo $node->nodeName." resets carry (inline non text).<br/>";
                $this->carryStack[$this->n] = false;
            }
            return;
        }
        if ($this->n == -1) {
            $node->nodeValue = "";
            return;
        }
        //echo "<hr/>".($node->parentNode->nodeName)." carry:".($this->carryStack[$this->n] ? "yes" : "no")."<br/>";
        $v = $this->basicTrim($node);
        //var_dump($v);
        $l = strlen($v);
        if ($l == 0) {
            $node->nodeValue = "";
            return;
        }
        if ($this->carryStack[$this->n] && $v[0] === " ") {
            $l--;
            $v = $l == 0 ? "" : substr($v, 1);
        }
        $this->carryStack[$this->n] = $l == 0 || $v[$l-1] === " ";
        //echo "carry now:".($this->carryStack[$this->n] ? "yes" : "no")."<br/>";
        $node->nodeValue = $v;
        //var_dump($v);
    }

    public function visitPost(DOMNode $node) {
        if ($this->isContext($node)) {
            array_pop($this->carryStack);
            $this->n--;
            //echo $node->nodeName." sets carry for parent (return from context).<br/>";
            $this->carryStack[$this->n] = true;
        }
    }

}


?>