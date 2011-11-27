<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UidGenerationVisitor
 *
 * @author short
 */
class UidGenerationVisitor implements ProviderTreeVisitor {

    private $uidStack = array();
    private $uid = 0;

    public function visitPre(Provider $provider) {
        $this->uidStack[] = array($this->uid, null);
        if ($provider instanceof PhysicalContent) {
            $this->uid += $provider->getPhysicalContentCount();
        }
    }

    public function visitPost(Provider $provider) {
        $range = array_pop($this->uidStack);
        $range[1] = $this->uid;
        //echo "set range for ".get_class($provider)." to ".$range[0]."/".$range[1]."<br/>";
        $provider->setRange($range);
    }

}
?>
