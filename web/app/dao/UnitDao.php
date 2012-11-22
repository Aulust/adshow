<?php

class UnitDao {
    private $dbh;

    public function UnitDao($dbh) {
        $this->dbh = $dbh;
    }

    public function getAll() {
        try {
            $sth = $this->dbh->prepare('SELECT unit_name as name, title, type FROM unit WHERE status = "active"');
            $sth->execute();
            $units = $sth->fetchAll(PDO::FETCH_CLASS, 'Unit');

            return $units;
        } catch(PDOException $e) {
            return null;
        }
    }

    public function get($name) {
        try {
            $sth = $this->dbh->prepare('SELECT unit_name as name, type, title, weight, link, image_url as imageUrl, html
                                        FROM unit WHERE unit_name = :name AND status = "active"');

            $sth->bindParam(':name', $name, PDO::PARAM_STR);
            $sth->execute();
            $unit = $sth->fetchObject('Unit');

            return $unit === false ? null : $unit;
        } catch(PDOException $e) {
            return null;
        }
    }

    public function getNames() {
        try {
            $sth = $this->dbh->prepare('SELECT unit_name as name FROM unit WHERE status = "active"');

            $sth->execute();
            $unit = $sth->fetchAll(PDO::FETCH_COLUMN);

            return $unit;
        } catch(PDOException $e) {
            return null;
        }
    }

    public function update($unit) {
        try {
            $sth = $this->dbh->prepare('UPDATE unit SET title = :title, weight = :weight, link = :link,
                                        image_url = :image_url, html = :html WHERE unit_name = :name');

            $sth->bindParam(':title', $unit->title, PDO::PARAM_STR);
            $sth->bindParam(':weight', $unit->weight, PDO::PARAM_INT);
            $sth->bindParam(':link', $unit->link, PDO::PARAM_STR);
            $sth->bindParam(':image_url', $unit->imageUrl, PDO::PARAM_STR);
            $sth->bindParam(':html', $unit->html, PDO::PARAM_STR);
            $sth->bindParam(':name', $unit->name, PDO::PARAM_STR);
            $sth->execute();
        } catch(PDOException $e) {
            return false;
        }

        return true;
    }

    public function insert($unit) {
        try {
            $sth = $this->dbh->prepare('INSERT INTO unit SET unit_name = :name, type = :type, title = :title,
                                        weight = :weight, link = :link, status = "active", image_url = :image_url, html = :html');

            $sth->bindParam(':name', $unit->name, PDO::PARAM_STR);
            $sth->bindParam(':type', $unit->type, PDO::PARAM_STR);
            $sth->bindParam(':title', $unit->title, PDO::PARAM_STR);
            $sth->bindParam(':weight', $unit->weight, PDO::PARAM_INT);
            $sth->bindParam(':link', $unit->link, PDO::PARAM_STR);
            $sth->bindParam(':image_url', $unit->imageUrl, PDO::PARAM_STR);
            $sth->bindParam(':html', $unit->html, PDO::PARAM_STR);
            $sth->execute();
        } catch(PDOException $e) {
            return false;
        }

        return true;
    }

    public function delete($unit) {
        try {
            $sth = $this->dbh->prepare('UPDATE unit SET status = "delete" WHERE unit_name = :name');

            $sth->bindParam(':name', $unit->name, PDO::PARAM_STR);
            $sth->execute();
        } catch(PDOException $e) {
            return false;
        }

        return true;
    }
}
