<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileSteward
 *
 * @author short
 */
class FileSteward {

    private $jobRecorder;
    private $handles;
    private $handleBackRef;
    private $handleCount = 0;

    public function __construct(JobRecorder $jobRecorder) {
        $this->jobRecorder = $jobRecorder;
        $this->handles[0]["fileId"] = 0;
        $this->handles[0]["name"] = "NULLFILE";
        $this->handles[0]["isPdf"] = false;
        $this->handleBackRef[0] = $this->handles[0];
    }

    private function isPdfInternal($file) {
        $fh = fopen($file, 'r');
        $signature = fread($fh, 7);
        fclose($fh);
        return $signature === "%PDF-1." ;
    }

    public function getStewardIdForFile($file) {
        if (isset($this->handles[$file]))
            return $this->handles[$file]["fileId"];

        $this->handleCount++;
        $this->handles[$file]["fileId"] = $this->handleCount;
        $this->handles[$file]["name"] = $file;
        $this->handles[$file]["isPdf"] = $this->isPdfInternal($file);
        $this->handleBackRef[$this->handleCount] = &$this->handles[$file];
        return $this->handleCount;
    }

    public function isPdf($fileId) {
        return $this->handleBackRef[$fileId]["isPdf"];
    }

    public function getFileHandle(Renderer $renderer, $fileId, $page = 1) {
        $hash = $renderer->getHash();
        if (isset($this->handleBackRef[$fileId]["pagehandles"][$page][$hash]))
            return $this->handleBackRef[$fileId]["pagehandles"][$page][$hash];
        else {
            extract($this->handleBackRef[$fileId]);
            if ($isPdf) {
                if (!isset($this->handleBackRef[$fileId]["filehandles"][$hash])) {
                    $fileHandle = $renderer->loadPDF($name);
                    $this->handleBackRef[$fileId]["filehandles"][$hash] = $fileHandle;
                } else {
                    $fileHandle = $this->handleBackRef[$fileId]["filehandles"][$hash];
                }
                $handle = array($fileHandle, $renderer->loadPDFPage($fileHandle, $page));
            } else {
                $handle = $renderer->loadImage($name, $page);
            }
            $this->handleBackRef[$fileId]["pagehandles"][$page][$hash] = $handle;
            return $handle;
        }
    }

    public function getImageSize($fileId) {
        $estimator = $this->jobRecorder->getEstimator();
        $w = $estimator->infoImage($fileId, "width", "");
        $h = $estimator->infoImage($fileId, "height", "");
        $res = $estimator->infoImage($fileId, "resx", "");
        if ($res <= 0.0) $res = 72.0;
        return array($w/$res*72.0, $h/$res*72.0);
    }

    public function getPDFPageSize($fileId) {
        $estimator = $this->jobRecorder->getEstimator();
        $w = $estimator->infoPDFPage($fileId, "width", 0);
        $h = $estimator->infoPDFPage($fileId, "height", 0);
        return array($w, $h);
    }



}
?>
