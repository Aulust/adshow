<?php

class Unit {
    public $name;
    public $type;
    public $title;
    public $weight;
    public $shows_limit;
    public $clicks_limit;
    public $time_limit;
    public $shows;
    public $clicks;
    public $link;
    public $imageUrl;
    public $html;

    public function setDefault() {
        $this->name = '';
        $this->type = '';
        $this->title = '';
        $this->weight = 1;
        $this->shows_limit = null;
        $this->clicks_limit = null;
        $this->time_limit = null;
        $this->link = '';
        $this->imageUrl = null;
        $this->html = null;
    }

    public function setDefaultNotUsed() {
        if($this->type === 'image') {
            $this->html = null;
        }
        if($this->type === 'html') {
            $this->imageUrl = null;
        }
    }
}
