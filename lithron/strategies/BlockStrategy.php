<?php

class BlockStrategy implements Strategy {

    public function layoutPre(JobRecorder $recorder, Provider $provider) {
        
        //var_dump($provider->getTagName());

        $a = $provider->getAttributes();
        if ($a[CSS::_POSITION] == CSS::_ABSOLUTE) {
            $parent = $recorder->getAbsoluteContainingBlock();
            $initialBox = CSSLayout::initialAbsoluteBlockFrame($a, $parent);
        } else {
            $parent = $recorder->getStaticContainingBlock();
            $initialBox = CSSLayout::initialStaticBlockFrame($a, $parent);
        }
        if ($provider instanceof PhysicalContent)
            $box = $provider->generateBox($initialBox, $provider->getRangeStart());
        else
            $box = new BlockBox($provider, $initialBox, $provider->getRange());
        $box->addDecorators($a);
        $recorder->enterElement($box);
    }

    public function layoutPost(JobRecorder $recorder, Provider $provider) {
        $box = $recorder->leaveElement();
        if ($box[CSS::_POSITION] == CSS::_ABSOLUTE) {
            $parent = $recorder->getAbsoluteContainingBlock();
            //echo get_class($parent)."<br/>";
            $box->finalize($parent);
            $parent->addAbsoluteBlock($box);
        } else {
            $parent = $recorder->getStaticContainingBlock();
            $box->finalize($parent);
            $parent->addStaticBlock($box);
        }
    }

}

?>