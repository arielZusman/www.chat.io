<?php

/**
* 
*/
class Observer implements SplObserver
{
	
	public function __construct($subject = null) {
        if (is_object($subject) && $subject instanceof SplSubject) {
            $subject->attach($this);
        }
    }

    public function update(SplSubject $subject) {
        // looks for an observer method with the state name
        if (method_exists($this, $subject->getState())) {
            call_user_func_array(array($this, $subject->getState()), array($subject));
        }
    }
}