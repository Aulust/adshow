<?php

class ValidationService {
    const UNIT_FORM_TOKEN_NAME = 'unit_form_token';
    const PLACEMENT_FORM_TOKEN_NAME = 'placement_form_token';

    public function validateUnit($unit, $token) {
        $errors = new UnitErrors();

        $errors->name = !$this->checkName($unit->name);
        $errors->type = !$this->checkType($unit->type);
        $errors->title = !$this->checkTitle($unit->title);
        $errors->weight = !$this->checkWeight($unit->weight);
        $errors->link = !$this->checkLink($unit->link);

        $errors->imageUrl = !$this->checkImageUrl($unit->imageUrl);
        $errors->html = !$this->checkHtml($unit->html);

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

    public function checkImageUrl($url) {
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
