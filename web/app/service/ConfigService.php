<?php

class ConfigService {
    private $config;
    
    public function ConfigService() {
        $this->config = parse_ini_file('../config/config');
    }
    
    public function getConfig() {
        return $this->config;
    }
}
