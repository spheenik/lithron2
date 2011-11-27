<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MemoryLogger
 *
 * @author short
 */
class MemoryLogger implements Logger {

    protected $level;
    protected $messages = array();
    protected $timers = array();

    public function __construct() {
        $this->level = Logger::INFO | Logger::WARNING | Logger::ERROR;
    }

    public function info($msg) {
        $this->messages[] = array(Logger::INFO, $msg);
    }

    public function warn($msg) {
        $this->messages[] = array(Logger::WARNING, $msg);
    }

    public function error($msg) {
        $this->messages[] = array(Logger::ERROR, $msg);
    }

    public function startTimer($id) {
        if (!isset($this->timers[$id])) {
            $this->timers[$id] = array(0.0, null);
        }
        if ($this->timers[$id][1] === null) {
            $this->timers[$id][1] = microtime(true);
        }
    }

    public function stopTimer($id) {
        if ($this->timers[$id][1] !== null) {
            $this->timers[$id][0] += microtime(true) - $this->timers[$id][1];
            $this->timers[$id][1] = null;
        }
    }

    public function readTimer($id) {
        $result = $this->timers[$id][0];
        if ($this->timers[$id][1] !== null) {
            $result += microtime(true) - $this->timers[$id][1];
        }
        return $result;
    }

    public function getMessages() {
        return $this->messages;
    }

    public function getTimers() {
        $result = array();
        foreach(array_keys($this->timers) as $id) {
            $result[] = array($id, $this->readTimer($id));
        }
        return $result;
    }


}
?>
