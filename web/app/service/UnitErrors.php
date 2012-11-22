<?php

class UnitErrors {
    public $name;
    public $type;
    public $title;
    public $weight;
    public $link;
    public $imageUrl;
    public $html;
    public $token;

    public function hasErrors() {
        if($this->name || $this->type || $this->title || $this->weight || $this->link || $this->token ||
            ($this->type === 'html' && $this->html) || ($this->type === 'image' && $this->imageUrl)) {
            return true;
        }

        return false;
    }
}
