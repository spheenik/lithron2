<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Visitor
 *
 * @author short
 */
interface ProviderTreeVisitor {

    public function visitPre(Provider $provider);
    public function visitPost(Provider $provider);

}
?>
