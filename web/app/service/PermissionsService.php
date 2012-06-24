<?php

class PermissionsService {
    private $role;
    static private $permissions = array('User' => array('view units', 'add unit', 'edit unit', 'delete unit',
                                                        'view placements', 'edit placement'),
                                        'Admin' => array('view units', 'add unit', 'edit unit', 'delete unit',
                                                         'view placements', 'add placement', 'edit placement', 'delete placement')
                                        );

    public function __construct() {
        $this->role = $_SERVER['PHP_AUTH_USER'];
    }

    public function checkPermission($permission) {
        return in_array($permission, PermissionsService::$permissions[$this->role]) ? true : false;
    }
}
