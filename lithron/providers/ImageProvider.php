<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ImageProvider extends BaseProvider implements PhysicalContent {

    protected $fileId;

    public function getFileId() {
        return $this->fileId;
    }

    public function init(DOMNode $node) {
    }

    public function getPhysicalContentCount() {
        return 1;
    }

    public function generateBox($frame) {

        $steward = $this->getJobRecorder()->getFileSteward();
        $estimator = $this->getJobRecorder()->getEstimator();
        $file = $this->attributes->getNonCssAttribute("src");
        $this->fileId = $steward->getStewardIdForFile($file);

        $a = $this->getAttributes();
        $scale = $a[CSS::_IMAGE_SCALE];
        $isPdf = $steward->isPDF($this->fileId);

        $i = $isPdf ? $steward->getPDFPageSize($this->fileId) : $steward->getImageSize($this->fileId);
        $i[0] *= $scale;
        $i[1] *= $scale;

        // specified
        $s = array($a[CSS::_WIDTH], $a[CSS::_HEIGHT]);

        $ac = ($s[0] === CSS::_AUTO ? 1 : 0) + ($s[1] === CSS::_AUTO ? 1 : 0);
        if ($ac == 2) {
            $s = $i;
        } else if ($ac == 1) {
            if ($s[0] === CSS::_AUTO) {
                $s[0] = $i[0] * $s[1] / $i[1];
            } else {
                $s[1] = $i[1] * $s[0] / $i[0];
            }
        }

        $frame[CSS::_WIDTH] = $s[0];
        $frame[CSS::_HEIGHT] = $s[1];

        $box = new ImageBox($this, $frame, $this->range);
        $box->isPdf = $isPdf;
        return $box;
    }
    
}

?>
