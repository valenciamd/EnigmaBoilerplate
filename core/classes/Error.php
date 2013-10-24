<?php

class Error{
    private $type;
    private $message;
    
    public function __construct($type, $message) {
        $this->type = $type;
        $this->message = $message;
    }
}