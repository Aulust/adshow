<?php

class Placement {
    public $name;
    public $title;
    public $width;
    public $height;

    public function setDefault() {
        $this->name = '';
        $this->title = '';
        $this->width = 0;
        $this->height = 0;
    }
}
