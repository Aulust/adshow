<?php

class UnitErrors {
    public $name;
    public $type;
    public $title;
    public $weight;
    public $link;
    public $imageUrl;
    public $imageType;
    public $imageFile;
    public $html;
    public $token;
    public $clicksLimit;
    public $showsLimit;
    public $timeLimit;

    public function hasErrors() {
        if($this->name || $this->type || $this->title || $this->weight || $this->link || $this->token || $this->html ||
           $this->imageUrl || $this->imageType || $this->imageFile || $this->clicksLimit || $this->showsLimit || $this->timeLimit) {
            return true;
        }

        return false;
    }
}
