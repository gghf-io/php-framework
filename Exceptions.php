<?php

class WrongPathException extends Exception {
    public function __construct() {
        $this->message = "Wrong path provided";
    }
}

class UnknownFileException extends Exception {
    public function __construct() {
        $this->message = "File not found";
    }
}