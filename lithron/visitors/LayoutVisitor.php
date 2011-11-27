<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LayoutVisitor
 *
 * @author short
 */
class LayoutVisitor implements ProviderTreeVisitor {

    public function visitPre(Provider $provider) {
        if (!$provider->getRendered()) return;
        $s = $provider->getStrategy();
        //echo "pre ".get_class($provider)."/".get_class($s)."<br/>";
        $s->layoutPre($provider->getJobRecorder(), $provider, 0);
    }

    public function visitPost(Provider $provider) {
        if (!$provider->getRendered()) return;
        $s = $provider->getStrategy();
        //echo "post ".get_class($provider)."/".get_class($s)."<br/>";
        $s->layoutPost($provider->getJobRecorder(), $provider);
    }

}
?>
