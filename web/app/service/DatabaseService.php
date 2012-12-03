<?php

class DatabaseService {
    private $dbh;
    
    public function __construct($config) {
        $dbhost = $config['dbhost'];
        $dbuser = $config['dbuser'];
        $dbpass = $config['dbpass'];
        $dbname = $config['dbname'];
        $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);

        $this->dbh = $dbh;
    }

    public function getConnection() {
        return $this->dbh;
    }

    public function disconnect() {
        $this->dbh = null;
    }

    public function beginTransaction() {
        $this->dbh->beginTransaction();
    }

    public function commitTransaction() {
        try {
            $this->dbh->commit();
        } catch(PDOException $e) {}
    }

    public function rollBackTransaction() {
        try {
            $this->dbh->rollBack();
        } catch(PDOException $e) {}
    }
}
