<?php

class ImageService {
    private $config;
    private $extension;
    public function ImageService($config) {
        $this->config = $config;
        $this->extension = 'jpeg';
    }
    
    public function uploadImage($name) {
        $imageUrl = $this->config['uploadDir'] . $name . '.' . $this->extension;
        if(move_uploaded_file($_FILES['imageUrl']['tmp_name'], '.' . $imageUrl) == true) {
            return $imageUrl;
        }
        else {
            return false;
        }
    }
    
    public function checkImage() {
        if(isset($_FILES['imageUrl'])) {
            if($_FILES['imageUrl']['error'] == 0) {
                $imageinfo = getimagesize($_FILES["imageUrl"]["tmp_name"]);
                if($imageinfo["mime"] != "image/gif" && $imageinfo["mime"] != "image/jpeg" && $imageinfo["mime"] !="image/png") {
                    return false;
                }
                else {
                    $mime = explode("/", $imageinfo["mime"]);
                    $this->extension = $mime[1];
                    return true;
                }
            }
            else 
                return false;
        }
        else 
            return false;
    }
}
