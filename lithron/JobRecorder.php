<?php


class JobRecorder {

    const SCOPE_ROOT = 0;
    const SCOPE_FILE = 1;
    const SCOPE_PAGE = 2;

    protected $jobId;
    protected $logger;
    protected $fontSteward;
    protected $fileSteward;
    protected $renderers;

    protected $scope = JobRecorder::SCOPE_ROOT;
    protected $files = array();
    protected $pages = array();
    protected $currentPage = null;
    protected $elementStack = null;

    protected $relativePrefix = "output";
    protected $absolutePrefix;
    protected $webDir;

    public function __construct(Logger $logger) {
        $this->jobId = uniqid();
        $this->logger = $logger;
        $this->fontSteward = new FontSteward($this);
        $this->fileSteward = new FileSteward($this);
        //$this->estimator = new PDFlibRenderer($this);
        //$this->estimator->beginDocument("");

        $this->relativePrefix = $this->relativePrefix.DIRECTORY_SEPARATOR.$this->jobId;
        $this->absolutePrefix = dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.$this->relativePrefix;
        $this->webPrefix = $this->relativePrefix;

        @mkdir($this->relativePrefix);
        if (!is_writable($this->relativePrefix))
            throw new LithronException("Output-directory is not writable.");
    }

    public function getJobId() {
        return $this->jobId;
    }

    public function getLogger() {
        return $this->logger;
    }

    public function getFontSteward() {
        return $this->fontSteward;
    }

    public function getFileSteward() {
        return $this->fileSteward;
    }

    public function getEstimator() {
        return count($this->renderers) ? end($this->renderers) : $this->estimator;
    }

    public function beginFile($name) {
        if ($name == null)
            $name = $this->jobId."_".(count($this->files)+1).".pdf";
        $file = DIRECTORY_SEPARATOR.$name;
        $this->files[] = array(
            "name" => $name,
            "file" => $this->relativePrefix.$file,
            "absoluteFile"=> $this->absolutePrefix.$file,
            "URL" => $this->webPrefix.$file,
        );
        $this->renderers[] = $r = new PDFlibRenderer($this);
        $r->beginDocument($this->absolutePrefix.$file);
        $this->scope = JobRecorder::SCOPE_FILE;
    }

    public function endFile() {
        $this->scope = JobRecorder::SCOPE_ROOT;
    }

    public function beginPage() {
        $frame = CSSLayout::frame(array(
            CSS::_DISPLAY => CSS::_BLOCK,
            CSS::_MAX_WIDTH => 14400.0,
            CSS::_MAX_HEIGHT => 14400.0,
        ));
        $this->currentPage = new PageBox(null, $frame, null);
        $this->elementStack = array($this->currentPage);
        $this->scope = JobRecorder::SCOPE_PAGE;
    }

    public function endPage() {
        $box = $this->leaveElement();
        $box->finalize(null);
        $this->pages[count($this->files)-1][] = $box;
        $this->currentPage = null;
        $this->elementStack = null;
        $this->scope = JobRecorder::SCOPE_FILE;
    }

    public function getCurrentFile() {
        return $this->files[count($this->files)-1];
    }

    public function getCurrentPage() {
        return $this->currentPage;
    }

    public function enterElement($blockContext) {
        $this->elementStack[] = $blockContext;
    }

    public function leaveElement() {
        $result = array_pop($this->elementStack);
        return $result;
    }

    public function getStaticContainingBlock() {
        for ($i = count($this->elementStack)-1; $i >= 0; $i--)
            if ($this->elementStack[$i][CSS::_DISPLAY] !== CSS::_INLINE)
                return $this->elementStack[$i];
    }

    public function getAbsoluteContainingBlock() {
        for ($i = count($this->elementStack)-1; $i >= 0; $i--)
            if ($this->elementStack[$i][CSS::_POSITION] !== CSS::_STATIC || $this->elementStack[$i] instanceof PageBox)
                return $this->elementStack[$i];
    }

    public function getRelativity() {
        $result = array(CSS::_TOP => null, CSS::_LEFT => null);
        for ($i = count($this->elementStack)-1; $i >= 0; $i--) {
            $el = $this->elementStack[$i];
            if ($el[CSS::_DISPLAY] !== CSS::_INLINE || $el instanceof PageBox)
                return $result;
            if ($el[CSS::_POSITION] !== CSS::_RELATIVE)
                continue;
            //echo get_class($el)."<br>";
            $result[CSS::_TOP] += $el[CSS::_TOP];
            $result[CSS::_LEFT] += $el[CSS::_LEFT];
            //CSSLayout::dumpFrame($result);
        }
        return $result;
    }

    public function getFiles() {
        return $this->files;
    }

    public function getPages() {
        return $this->pages;
    }

    public function render() {
        $c = count($this->files);
        for ($i = 0; $i < $c; $i++) {
            $pages = $this->pages[$i];
            $renderer = $this->renderers[$i];
            foreach($pages as $page)
                $page->render($renderer);
            $renderer->endDocument();
        }
    }

    public function getLayoutDump() {
        $result = array();
        foreach($this->pages as $fileIndex => $pages) {
            unset($pageDump);
            foreach($pages as $page) {
                ob_start();
                LayoutDumper::dump($page);
                $pageDump[] = ob_get_contents();
                ob_end_clean();
            }
            $result[] = $pageDump;
        }
        return $result;
    }

    public function getCommandDump() {
        $result = array();
        foreach($this->renderers as $renderer) {
            $result[] = $renderer->getCommandDump();
        }
        return $result;
    }

}

?>