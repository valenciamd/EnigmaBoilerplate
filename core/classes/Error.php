<?php

class Error{
    private $type;
    private $message;
    
    public function __construct($type, $message) {
        $this->type = $type;
        $this->message = $message;
    }
    
    public function getError(){
        $error = array(
            'type'      => $this->type,
            'message'   => $this->message
        );
        
        return $error;
    }
}