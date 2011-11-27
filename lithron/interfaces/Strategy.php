<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Strategy
 *
 * @author short
 */
interface Strategy {

    public function layoutPre(JobRecorder $recorder, Provider $provider);
    public function layoutPost(JobRecorder $recorder, Provider $provider);

}
?>
