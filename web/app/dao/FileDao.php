<?php

class FileDao {
    private $dbh;

    function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function getUniqueName() {
        try {
            $sth = $this->dbh->prepare('UPDATE filename_sequence SET id = LAST_INSERT_ID(id + 1)');
            $sth->execute();
            $sth = $this->dbh->prepare('SELECT LAST_INSERT_ID()');
            $sth->execute();
            $name = $sth->fetchColumn();
        } catch(PDOException $e) {
            return null;
        }

        return $name;
    }
}
