<?php

class Unit {
    public $name;
    public $type;
    public $title;
    public $weight;
    public $showsLimit;
    public $clicksLimit;
    public $timeLimit;
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
        $this->showsLimit = null;
        $this->clicksLimit = null;
        $this->timeLimit = null;
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
