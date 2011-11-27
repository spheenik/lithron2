<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class TextStrategy {

    public function layoutPre(JobRecorder $recorder, Provider $provider) {
        $container = $recorder->getStaticContainingBlock();
        $ov = $recorder->getRelativity();
        $range = $provider->getRange();
        do {
            $provider->generateRange($range[0], $container);
            $b = $provider->generateBox(CSSLayout::frame($ov));
            $b->addDecorators($provider->getAttributes());
            $container->addInline($b);
            $range[0] = $b->getRangeEnd();
        } while ($range[0] < $range[1]);
    }

    public function layoutPost(JobRecorder $recorder, Provider $provider) {
    }

}
?>
