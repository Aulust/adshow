<?php

class ValidationService {
    const UNIT_FORM_TOKEN_NAME = 'unit_form_token';
    const PLACEMENT_FORM_TOKEN_NAME = 'placement_form_token';

    public function validateUnit($unit, $token, $type) {
        $errors = new UnitErrors();

        $errors->name = !$this->checkName($unit->name);
        $errors->type = !$this->checkType($unit->type);
        $errors->title = !$this->checkTitle($unit->title);
        $errors->weight = !$this->checkWeight($unit->weight);
        if($unit->type=='image') {
			$errors->link = !$this->checkLink($unit->link);
			$errors->imageUrl = !$this->checkImageUrl($unit->imageUrl, $type);
			$errors->html = false;
		}
		else if($unit->type=='html') {
			$errors->link = false;
			$errors->imageUrl = false;
			$errors->html = !$this->checkHtml($unit->html);
		}
		$errors->clicks_limit = !$this->checkClicksLimit($unit->clicks_limit);
		$errors->shows_limit = !$this->checkShowsLimit($unit->shows_limit);
		$errors->time_limit = !$this->checkTimeLimit($unit->time_limit);

        $errors->token = !$this->checkToken(ValidationService::UNIT_FORM_TOKEN_NAME, $token);

        return $errors;
    }

    public function validatePlacement($placement, $showingUnitNames, $unitNames, $token) {
        $errors = new PlacementErrors();

        $errors->name = !$this->checkName($placement->name);
        $errors->title = !$this->checkTitle($placement->title);
        $errors->units = !$this->checkUnitNames($showingUnitNames, $unitNames);

        $errors->token = !$this->checkToken(ValidationService::PLACEMENT_FORM_TOKEN_NAME, $token);

        return $errors;
    }

    public function checkName($name) {
        return $name != '' && !preg_match('/[^A-Za-z0-9.]/', $name);
    }

    public function checkTitle($title) {
        return $title !== '';
    }

    public function checkType($type) {
        return $type === 'html' || $type === 'image' ? true : false;
    }

    public function checkLink($link) {
        return $link != '' && filter_var($link, FILTER_VALIDATE_URL) != false;
    }

    public function checkWeight($weight) {
        return $weight != '' && filter_var($weight, FILTER_VALIDATE_INT) != false && $weight >= 1 && $weight <= 100;
    }

     public function checkClicksLimit($clicks_limit) {
        if($clicks_limit == null) 
            return true;
        else 
            return filter_var($clicks_limit, FILTER_VALIDATE_INT) !== false && $clicks_limit > 0;
    }

     public function checkShowsLimit($shows_limit) {
        if($shows_limit == null) 
            return true;
        else 
            return filter_var($shows_limit, FILTER_VALIDATE_INT) !== false && $shows_limit > 0;
    }

    public function checkTimeLimit($time_limit) {
        return true;
    }

    public function checkImageUrl($url, $type) {
        if($type == 'update' && (($url == '' && isset($_FILES['imageUrl']) && $_FILES["imageUrl"]["tmp_name"]=='') || ($url == '' && !isset($_FILES['imageUrl'])))) return true;
		if(isset($_FILES['imageUrl'])) {
            if($_FILES['imageUrl']['error'] == 0) {
                $imageinfo = getimagesize($_FILES["imageUrl"]["tmp_name"]);
                if($imageinfo["mime"] != "image/gif" && $imageinfo["mime"] != "image/jpeg" && $imageinfo["mime"] !="image/png") {
                    return false;
                }
                else 
                    return true;
            }
            else 
                return false;
        }
		else 
			return $url != '' && filter_var($url, FILTER_VALIDATE_URL) != false;
    }

    public function checkHtml($html) {
        return $html != '';
    }

    public function checkUnitNames($checkingUnitNames, $unitNames) {
        if(!is_array($checkingUnitNames)) {
            return false;
        }

        $result = true;

        foreach($checkingUnitNames as $checkingUnitName) {
            if(!in_array($checkingUnitName, $unitNames)) {
                $result = false;
                break;
            }
        }

        return $result;
    }

    public function generateToken($name) {
        $token = md5(uniqid(rand(), TRUE));
        $_SESSION[$name] = $token;
        return $token;
    }

    public function checkToken($name, $token) {
        if(!isset($_SESSION[$name]))
            return false;
        return $_SESSION[$name] === $token;
    }
}
