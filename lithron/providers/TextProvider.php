<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TextProvider extends BaseProvider implements PhysicalContent, Splittable {

    private $text;
    private $lengths;
    private $n;
    private $span;
    private $spaceWidth;

    public function init($v) {
        $a = $this->getAttributes();
        $t = preg_split("/(\s)/", $v, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        if ($a[CSS::_WHITE_SPACE] == CSS::_PRE_WRAP) {
            $this->text = array();
            foreach($t as $subt) {
                $subt = preg_split("/(?<=&#32;)(?!&#32;)/", $subt, -1, PREG_SPLIT_NO_EMPTY);
                $this->text = array_merge($this->text, $subt);
            }
        } else
            $this->text = $t;

        $this->n = count($this->text);
        //var_dump($this->text);
        //var_dump($this->lengths);
    }

    public function getPhysicalContentCount() {
        return count($this->text);
    }

    public function getStrategy() {
        return StrategyFactory::get("text");
    }

    public function generateRange($start, BlockBox $container) {
        if (!is_array($this->lengths)) {
            $steward = $this->getJobRecorder()->getFontSteward();
            $a = $this->getAttributes();
            $fontId = $a->getFontId();
            $fontSize = $a[CSS::_FONT_SIZE];
            $this->spaceWidth = $steward->getStringWidth($fontId, $fontSize, " ");
            $this->lengths = array();
            foreach($this->text as $v)
                switch ($v) {
                case "\n":  $this->lengths[] = 0.0; break;
                default:    $this->lengths[] = $steward->getStringWidth($fontId, $fontSize, $v);
            }
        }

        $i0 = $start - $this->range[0];
        $i = $i0 + 1;
        if ($this->text[$i0] === "\n") {
            $this->span = array($i0, $i, 0.0);
            return;
        }
        $w = $this->lengths[$i0];
        if ($this->text[$i0] === " " && $i < $this->n) {
            $w += $this->lengths[$i];
            $i++;
        }
        $socl = $container->spaceOnCurrentLine();
        $space = $w <= $socl ? $socl : $container->spaceOnNewLine();
        while($i < $this->n && $this->text[$i] !== "\n" && $w + $this->lengths[$i] <= $space) {
            $w += $this->lengths[$i];
            $i++;
        }
        $this->span = array($i0, $i, $w);
    }

    public function generateBox($frame) {
        $steward = $this->getJobRecorder()->getFontSteward();
        $a = $this->getAttributes();
        $fontId = $a->getFontId();
        $fontSize = $a[CSS::_FONT_SIZE];
        $lineHeight = $a[CSS::_LINE_HEIGHT];
        $asc = $steward->getFontMetrics($fontId, "ascender") * $fontSize;
        $desc = $steward->getFontMetrics($fontId, "descender") * $fontSize;
        $intrinsicHeight = $asc + $desc;

        list($i0, $i, $w) = $this->span;
        $rt = implode(array_slice($this->text, $i0, $i - $i0));

        $frame[CSS::_WIDTH] = $w;
        $frame[CSS::_HEIGHT] = $lineHeight;

        $range = array($this->range[0] + $i0, $this->range[0] + $i);
        if ($rt === "\n") {
            $box = new LineBreakBox($this, $frame, $range);
        }
        else
            $box = new TextSpanBox($this, $frame, $range);
        $box->descender = $desc + ($lineHeight - $intrinsicHeight) * 0.5;
        $box->text = $rt;

        $l = strlen($rt);
        $box->lTrim = $rt[0] == " " ? $this->spaceWidth : 0.0;
        $box->rTrim = $rt[$l-1] == " " ? $this->spaceWidth : 0.0;
        $box->breakable = !in_array($a[CSS::_WHITE_SPACE], array(CSS::_PRE, CSS::_NOWRAP));
        //echo "box: ".$box->getRangeStart()."/".$box->getRangeEnd().", max ".$this->range[1]." ($rt)<br/>";
        //echo $box->lTrim."/".$box->rTrim." ($rt)<br/>";
        return $box;
    }


}

?>
