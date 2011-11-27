<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FileStrategy implements Strategy {

    public function layoutPre(JobRecorder $recorder, Provider $provider) {
        $name = $provider->getAttributes()->getNonCssAttribute("name");
        $recorder->beginFile($name);
    }

    public function layoutPost(JobRecorder $recorder, Provider $provider) {
        $name = $provider->getAttributes()->getNonCssAttribute("name");
        $recorder->endFile($name);
    }

}
?>
