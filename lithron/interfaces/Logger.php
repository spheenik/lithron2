<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logger
 *
 * @author short
 */
interface Logger {

    const INFO = "info";
    const WARNING = "warning";
    const ERROR = "error";

    public function info($msg);
    public function warn($msg);
    public function error($msg);

    public function startTimer($id);
    public function stopTimer($id);
    public function readTimer($id);

    public function getMessages();
    public function getTimers();

}
?>
