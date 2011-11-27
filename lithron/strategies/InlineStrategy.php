<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class InlineStrategy {

    public function layoutPre(JobRecorder $recorder, Provider $provider) {
        $a = $provider->getAttributes();
        if ($provider instanceof PhysicalContent)
            $box = $provider->generateBox(CSSLayout::frame(), $provider->getRangeStart());
        else
            $box = new CompositeBox($provider, CSSLayout::initialInlineFrame($a), $provider->getRange());
        $box->addDecorators($a);
        //echo "enter ".get_class($box)."/".CSS::toString($box[CSS::_POSITION])."<br/>";
        $parent = $recorder->getStaticContainingBlock();
        $parent->addInline($box);
        $recorder->enterElement($box);
    }

    public function layoutPost(JobRecorder $recorder, Provider $provider) {
        $box = $recorder->leaveElement();
        //echo "leave ".get_class($box)."<br/>";
    }

}
?>
