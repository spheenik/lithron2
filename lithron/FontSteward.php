<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FontSteward
 *
 * @author short
 */
class FontSteward {

	private $families = array(
		CSS::_COURIER => array(
                        400 => array(
                            CSS::_NORMAL => array("name" => "Courier"),
                            CSS::_ITALIC => array("name" => "Courier-Oblique"),
                        ),
                        700 => array(
                            CSS::_NORMAL => array("name" => "Courier-Bold"),
                            CSS::_ITALIC => array("name" => "Courier-BoldOblique"),
                        )
		),
		CSS::_HELVETICA => array(
                        400 => array(
                            CSS::_NORMAL => array("name" => "Helvetica"),
                            CSS::_ITALIC => array("name" => "Helvetica-Oblique"),
                        ),
                        700 => array(
                            CSS::_NORMAL => array("name" => "Helvetica-Bold"),
                            CSS::_ITALIC => array("name" => "Helvetica-BoldOblique"),
                        )
		),
		CSS::_TIMES => array(
                        400 => array(
                            CSS::_NORMAL => array("name" => "Times-Roman"),
                            CSS::_ITALIC => array("name" => "Times-Italic"),
                        ),
                        700 => array(
                            CSS::_NORMAL => array("name" => "Times-Bold"),
                            CSS::_ITALIC => array("name" => "Times-BoldItalic"),
                        )
		),
		CSS::_ZAPF => array(
                        400 => array(
                            CSS::_NORMAL => array("name" => "ZapfDingbats"),
                        ),
		),

	);

    private $jobRecorder;
    private $handles;
    private $handleBackRef;
    private $handleCount = -1;
    private $metricsCache;
    private $sizeCache;

    public function __construct(JobRecorder $jobRecorder) {
        $this->jobRecorder = $jobRecorder;
        $this->families[CSS::_SERIF] = &$this->families[CSS::_TIMES];
        $this->families[CSS::_SANS_SERIF] = &$this->families[CSS::_HELVETICA];
        $this->families[CSS::_MONOSPACE] = &$this->families[CSS::_COURIER];
    }

    public function setFamily($family, $weight, $style, $properties) {
        $this->families[$family][$weight][$style] = $properties;
    }

    private function calculateWeight($cssWeight) {
        if (is_double($cssWeight))
            return (int)$cssWeight;
        switch($cssWeight) {
            case CSS::_NORMAL: return 400;
            case CSS::_BOLD: return 700;
        }

        return 400;
    }

    public function getStewardIdForAttributes(Attributes $attributes) {
        $jobId = $this->jobRecorder->getJobId();

        $family = $attributes[CSS::_FONT_FAMILY];
        if (!isset($this->families[$family])) {
            $this->jobRecorder->getLogger()->warn("cannot load unknown font family ".CSS::toString($family).", using TIMES");
            $family = CSS::_TIMES;
        }

        $weight = $this->calculateWeight($attributes[CSS::_FONT_WEIGHT]);
        if (!isset($this->families[$family][$weight])) {
            $this->jobRecorder->getLogger()->warn("no font cut with weight $weight for font family ".CSS::toString($family).", using 400");
            $weight = 400;
        }

        $style = $attributes[CSS::_FONT_STYLE];
        if (!isset($this->families[$family][$weight][$style])) {
            $this->jobRecorder->getLogger()->warn("no font cut with style ".CSS::toString($style)." for font family ".CSS::toString($family)." and weight $weight, using NORMAL");
            $style = CSS::_NORMAL;
        }

        if (isset($this->handles[$jobId][$family][$weight][$style]))
            return $this->handles[$jobId][$family][$weight][$style]["fontId"];

        $this->handleCount++;
        $this->handles[$jobId][$family][$weight][$style]["fontId"] = $this->handleCount;
        $this->handles[$jobId][$family][$weight][$style]["family"] = $family;
        $this->handles[$jobId][$family][$weight][$style]["weight"] = $weight;
        $this->handles[$jobId][$family][$weight][$style]["style"] = $style;
        $this->handleBackRef[$this->handleCount] = &$this->handles[$jobId][$family][$weight][$style];
        return $this->handleCount;
    }

    public function getStringWidth($fontId, $fontSize, $word) {
        if (isset($this->sizeCache[$fontId][$word]))
            return $this->sizeCache[$fontId][$word] * $fontSize;
        $estimator = $this->jobRecorder->getEstimator();
        $this->sizeCache[$fontId][$word] = $estimator->getStringWidth($fontId, 1, $word);
        return $this->sizeCache[$fontId][$word] * $fontSize;
    }

    public function getFontMetrics($fontId, $metrics) {
        if (isset($this->metricsCache[$fontId][$metrics]))
            return $this->metricsCache[$fontId][$metrics];

        switch($metrics) {
            case "spacewidth":
                $result = $this->getStringWidth($fontId, 1, " ");
                break;
            case "descender":
                $result = -$this->jobRecorder->getEstimator()->getFontMetrics($fontId, $metrics);
                break;
            default:
                $result = $this->jobRecorder->getEstimator()->getFontMetrics($fontId, $metrics);
        }

        $this->metricsCache[$fontId][$metrics] = $result;
        return $result;
    }

    public function getFontHandle(Renderer $renderer, $fontId) {
        $hash = $renderer->getHash();
        if (isset($this->handleBackRef[$fontId][$hash]))
            return $this->handleBackRef[$fontId][$hash];
        else {
            extract($this->handleBackRef[$fontId]);
            $f = $this->families[$family][$weight][$style];
            $emb = isset($f["embedding"]) ? $f["embedding"] : false;
            $enc = isset($f["encoding"]) ? $f["encoding"] : "unicode";
            $handle = $renderer->loadFont($f["name"], $enc, $emb);
            $this->handleBackRef[$fontId][$hash] = $handle;
            return $handle;
        }
    }




}
?>
