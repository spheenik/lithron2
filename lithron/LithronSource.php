<?php

class LithronSource {

    protected $rawXML = null;
    protected $cleanedXML = null;
    protected $document = null;
    protected $xPath = null;
    protected $logger = null;

    public function __construct(Logger $logger, $xml) {

        $this->logger = $logger;
        $this->logger->startTimer("total");

        $this->rawXML = $xml;
        $this->cleanedXML = $this->cleanXML($this->rawXML);

        $this->document = new DOMDocument();
        $this->document->registerNodeClass("DOMText", "AttributesHolderText");
        $this->document->registerNodeClass("DOMElement", "AttributesHolderElement");
        if ($this->document->loadXML($this->cleanedXML) === false) {
            throw new LithronException("Can not load XML");
        }

        // make autoload load the tree classes
        $x = new CSSTree();
        $this->logger->stopTimer("total");
    }

    public function work() {
        $this->logger->startTimer("total");

        $jobRecorder = new JobRecorder($this->logger);
        $this->xPath = new DOMXPath($this->document);
        $rootNode = $this->document->documentElement;
        $this->initializeFonts($jobRecorder);

        $query = "//comment()";
        $allNodes = $this->xPath->query($query);
        foreach($allNodes as $node)
            $node->parentNode->removeChild($node);

        $this->logger->startTimer("styling");

        $query = "//*|//text()";
        $allNodes = $this->xPath->query($query);
        foreach($allNodes as $node)
            $node->init($jobRecorder->getFontSteward());

        $this->queueStyles();
        $rootNode->accept(new StylingVisitor());

        $this->logger->stopTimer("styling");
        $this->logger->startTimer("generating providers");

        $rootNode->accept(new TextSetupVisitor());
        $gen = new ProviderGenerationVisitor($jobRecorder);
        $rootNode->accept($gen);
        $rootProvider = $gen->getRootProvider();
        $rootProvider->accept(new UidGenerationVisitor());

        $this->logger->stopTimer("generating providers");
        $this->logger->startTimer("layout");

        $rootProvider->accept(new LayoutVisitor());

        $this->logger->stopTimer("layout");
        $this->logger->startTimer("rendering");

        $jobRecorder->render();

        $this->logger->stopTimer("rendering");

        $this->logger->stopTimer("total");

        return $jobRecorder;
    }

    private function cleanXML($xml) {
        $trans = array(
            "&amp;" => "&amp;amp;",
            "&lt;" => "&amp;lt;",
            "&gt;" => "&amp;gt;",
        );
        $xml = html_entity_decode(strtr($xml, $trans), ENT_COMPAT, "UTF-8");
        $search = array("/&empty;/", "/&nbsp;/", "/<br[ ]*?>/", "/%[Cc][Bb]%/", "/%[Pp][Bb]%/");
        $replace = array("&#216;", "&amp;nbsp;", "<br/>", "<cbr/>", "<pbr/>");
        return preg_replace($search, $replace, $xml);
    }

    private function loadCSS($css) {
        $hash = md5($css);
        $name = "output/css_$hash.ser";
        if (is_readable($name)) {
            $fh = fopen($name, "r");
            $hash = fread($fh, strlen(CSS::HASH));
            if ($hash == CSS::HASH)
                $ret = unserialize(fread($fh, 100000000));
            fclose($fh);
            if (isset($ret)) return $ret;
        }
        ob_start();
        $l = new csslex($css);
        $p = new cssparse($l);
        //$p->setdebug(1);
        $p->yyparse();
        ob_end_clean();
        file_put_contents($name, CSS::HASH.serialize($p->parseResult()));
        //var_dump($p->parseResult());
        return $p->parseResult();
    }

    private function applyCSS($root, $css, $prefix, $baseSpec) {

        foreach($css->values as $ruleSet)
            foreach($ruleSet->declarations->values as $decl)
                if ($decl->attributes === null) {
                    $msg = $decl->property->toString().": ".$decl->expression->toString(" ");
                   $this->logger->warn("ignoring invalid css declaration $msg in selector ".$ruleSet->selectors->toString(" | "));
                }
        //var_dump($css);
        foreach($css->values as $ruleSet) {
            foreach($ruleSet->selectors->values as $selector) {
                if ($prefix == ".") {
                    $nodes = array($root->ownerElement);
                    $spec = $baseSpec;
                    //echo "no query.<br/>";
                } else {
                    $query = $prefix.$selector->toXPath();
                    $spec = $baseSpec + $selector->specifity();
                    $nodes = $this->xPath->query($query, $root);
                    //echo "querying $query (spec: $spec) got ".$nodes->length." nodes.<br/>";
                }
                foreach($nodes as $node) {
                    foreach($ruleSet->declarations->values as $decl) {
                        // attributes is null if it is not valid
                        if ($decl->attributes === null) continue;
                        //echo "assign<br/>";
                        $node->getAttributes()->queueAttributes($decl->attributes, $spec + $decl->priority*0x10000000);
                    }
                }
            }
        }
    }

    private function queueStyles() {

        $css = $this->loadCSS(file_get_contents(dirname(__FILE__)."/LithronStylesheet.css"));
        $this->applyCSS($this->document->documentElement, $css, "//", 0x01000000);

        $stylenodes = $this->xPath->query($q = '//style/text()');
        foreach($stylenodes as $node) {
            $css = $this->loadCSS($node->wholeText);
            $s = $node->parentNode;
            $this->applyCSS($s, $css, "//", 0x02000000); // does not work with first-child? ./following-sibling::*/descendant-or-self::
            $s->parentNode->removeChild($s);
        }

        $styleattrs = $this->xPath->query($q = '//@style');
        foreach($styleattrs as $node) {
            $css = $this->loadCSS("a {".$node->value."}");
            $this->applyCSS($node, $css, ".", 0x04000000);
        }

        $specattrs = $this->xPath->query($q = '//@*'); // maybe we want to omit non style attributes
        foreach($specattrs as $node) {
            $node->ownerElement->getAttributes()->addNonCssAttribute($node->name, $node->value);
        }
    }

    private function initializeFonts($jobRecorder) {
        // read all font nodes
        $fonts = $this->xPath->query("//font");
        foreach($fonts as $font) {
            $fam = $font->getAttribute("font-family");
            if ($fam == "") continue;
            $defaultEmbed = $this->xPath->query("./embedding", $font)->length != 0;
            $weights = $this->xPath->query(".//weight", $font);
            foreach($weights as $weight) {
                $wid = $weight->getAttribute("id");
                $styles = $this->xPath->query(".//style", $weight);
                foreach($styles as $style) {
                    $styleText = $this->xPath->query(".//text()", $style);
                    $sid = $style->getAttribute("id");
                    switch($sid) {
                        case "normal": $sid = CSS::_NORMAL; break;
                        case "italic": $sid = CSS::_ITALIC; break;
                        case "oblique": $sid = CSS::_OBLIQUE; break;
                        default:
                            $this->logger->warning("ignoring unknown font-style '{".$sid."}' in font declaration.");
                            break 2;
                    }
                    $item = array();
                    $item["name"] = $styleText->item(0)->wholeText;
                    $item["embedding"] = $defaultEmbed;
                    $jobRecorder->getFontSteward()->setFamily($fam, $wid, $sid, $item);

                }
            }
            $font->parentNode->removeChild($font);
        }

    }

    public function getCleanedXML() {
        return $this->cleanedXML;
    }

}

?>
