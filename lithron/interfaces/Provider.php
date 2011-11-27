<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author short
 */
interface Provider {
    public function setRange(array $range);
    public function getRange();
    public function getAttributes();
    public function getTagName();
    public function setRendered($bool);

    public function getStrategy();

    public function accept(ProviderTreeVisitor $visitor);
}
?>
