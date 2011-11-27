<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author short
 */
interface Renderer {
    public function beginDocument($name);
    public function endDocument();
    public function beginPage($w, $h);
    public function endPage();

    public function save();
    public function restore();

    public function translate($x, $y);

    public function setColor($which, $col);
    public function rect($x, $y, $w, $h);

    public function loadFont($name, $encoding, $embedding);
    public function setFont($fontId, $fontSize);
    public function getStringWidth($fontId, $fontSize, $word);
    public function outputText(Attributes $a, $text);

    public function loadImage($name, $page);
    public function infoImage($fileId, $which, $params);
    public function putImage($fileId, $w, $h, $position, $fitmethod, $scale);

    public function loadPDF($name);
    public function loadPDFPage($fileHandle, $page);
    public function infoPDFPage($fileId, $which, $params);
    public function putPDFPage($fileId, $w, $h, $position, $fitmethod, $scale);

}
?>
