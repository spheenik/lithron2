<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class PageStrategy extends BlockStrategy {

    public function layoutPre(JobRecorder $recorder, Provider $provider) {
        $recorder->beginPage();
        parent::layoutPre($recorder, $provider);
    }

    public function layoutPost(JobRecorder $recorder, Provider $provider) {
        parent::layoutPost($recorder, $provider);
        $recorder->endPage();
    }

}
?>
