<?php

class PlacementErrors {
    public $name;
    public $title;
    public $units;
    public $token;

    public function hasErrors() {
        if($this->name || $this->title || $this->units || $this->token) {
            return true;
        }

        return false;
    }
}
