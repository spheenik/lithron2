<?php
/**
 *
 *
 * Description of PDFlibRenderer
 *
 * @author short
 */
class PDFlibRenderer implements Renderer {

    protected $jobRecorder;

    protected $hash;

    protected $pdf;
    protected $name;


    public function __construct(JobRecorder $jobRecorder) {
        $this->jobRecorder = $jobRecorder;
        $this->hash = spl_object_hash($this);
    }

    public function getHash() {
        return $this->hash;
    }

    public function beginDocument($name) {
        $this->pdf = new CommandRecorder();
        $this->pdf->set_parameter("debug", "h");
        $this->pdf->set_parameter("textformat", "utf8");
        $this->pdf->set_parameter("charref", "true");
        $this->pdf->begin_document($name, "");
        $this->name = $name;
    }

    public function endDocument() {
        $this->pdf->end_document("");
    }

    public function beginPage($w, $h) {
        $this->pdf->begin_page_ext($w, $h, "");
    }

    public function endPage() {
        $this->pdf->end_page_ext("");
    }

    public function save() {
        $this->pdf->save();
    }

    public function restore() {
        $this->pdf->restore();
    }

    public function translate($x, $y) {
        $this->pdf->translate($x, $y);
    }

    public function setColor($which, $color) {
        array_unshift($color, $which);
        $color = array_pad($color, 6, 0.0);
        call_user_func_array(array($this->pdf, "setcolor"), $color);
    }

    public function rect($x, $y, $w, $h) {
        $this->pdf->rect($x, $y, $w, $h);
        $this->pdf->fill();
    }

    public function loadFont($name, $encoding, $embedding) {
        return $this->pdf->load_font($name, $encoding, PDFlibOptionString::build("embedding", $embedding));
    }

    public function setFont($fontId, $fontSize) {
        $fh = $this->jobRecorder->getFontSteward()->getFontHandle($this, $fontId);
        $this->pdf->setfont($fh, $fontSize);
    }

    public function getStringWidth($fontId, $fontSize, $text) {
        $fh = $this->jobRecorder->getFontSteward()->getFontHandle($this, $fontId);
        return $this->pdf->stringwidth($text, $fh, $fontSize);
    }

    public function getFontMetrics($fontId, $metrics) {
    //$checks = array("capheight", "ascender", "descender", "xheight");
        $fh = $this->jobRecorder->getFontSteward()->getFontHandle($this, $fontId);
        return $this->pdf->get_value("$metrics", $fh);
    }

    public function outputText(Attributes $a, $text) {
        $td = $a[CSS::_TEXT_DECORATION];
        if ($td === CSS::_NONE)
            $td = array();
        else if (!is_array($td))
            $td = array($td);
        $opt = PDFlibOptionString::build(
            "font", "".$this->jobRecorder->getFontSteward()->getFontHandle($this, $a->getFontId()),
            "fontsize", $a[CSS::_FONT_SIZE],
            "fillcolor", $a[CSS::_COLOR],
            "underline", in_array(CSS::_UNDERLINE, $td),
            "overline", in_array(CSS::_OVERLINE, $td),
            "strikeout", in_array(CSS::_LINE_THROUGH, $td)
        );
        //var_dump($opt);
        $this->pdf->fit_textline($text, 0, 0, $opt);
    }

    public function loadImage($file, $page) {
        return $this->pdf->load_image("auto", $file, "");
    }

    public function infoImage($fileId, $which, $params) {
        $handle = $this->jobRecorder->getFileSteward()->getFileHandle($this, $fileId);
        return $this->pdf->info_image($handle, $which, $params);
    }

    public function putImage($fileId, $w, $h, $position, $fitmethod, $scale) {
        $handle = $this->jobRecorder->getFileSteward()->getFileHandle($this, $fileId);
        if ($handle == 0)
            return;
        $opt = PDFlibOptionString::build(
            "boxsize", array($w, $h),
            "position", $position,
            "fitmethod", $fitmethod,
            "scale", $scale
        );
        //var_dump($opt);
        $this->pdf->fit_image($handle, 0, 0, $opt);
    }

    public function loadPDF($file) {
        return $this->pdf->open_pdi_document($file, "");
    }

    public function loadPDFPage($fileHandle, $page) {
        return $this->pdf->open_pdi_page($fileHandle, $page, "");
    }

    public function infoPDFPage($fileId, $which, $params) {
        list($doc, $page) = $this->jobRecorder->getFileSteward()->getFileHandle($this, $fileId);
        return $this->pdf->get_pdi_value($which, $doc, $page, $params);
    }

    public function putPDFPage($fileId, $w, $h, $position, $fitmethod, $scale) {
        list($doc, $page) = $this->jobRecorder->getFileSteward()->getFileHandle($this, $fileId);
        $opt = PDFlibOptionString::build(
            "boxsize", array($w, $h),
            "position", $position,
            "fitmethod", $fitmethod,
            "scale", $scale
        );
        //var_dump($opt);
        $this->pdf->fit_pdi_page($page, 0, 0, $opt);
        
    }

    public function getCommandDump() {
        return $this->pdf->dump;
    }

}
?>
