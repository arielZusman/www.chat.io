<?php 

/**
* 
*/
class Subject implements SplSubject
{
	
	protected $observers;
    protected $state;

    public function __construct() {
        $this->observers = array();
        $this->state = null;
    }

    public function attach(SplObserver $observer) {
        $i = array_search($observer, $this->observers);
        if ($i === false) {
            $this->observers[] = $observer;
        }
    }

    public function detach(SplObserver $observer) {
        if (!empty($this->observers)) {
            $i = array_search($observer, $this->observers);
            if ($i !== false) {
                unset($this->observers[$i]);
            }
        }
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
        $this->notify();
    }

    public function notify() {
        if (!empty($this->observers)) {
            foreach ($this->observers as $observer) {
                $observer->update($this);
            }
        }
    }


    public function getObservers() {
        return $this->observers;
    }
}