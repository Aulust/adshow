<?php

class UnitDao {
    private $dbh;
    private $config;

    public function __construct($dbh, $config) {
        $this->dbh = $dbh;
        $this->config = $config;
    }

    public function getAll() {
        try {
            $sth = $this->dbh->prepare('SELECT unit.unit_name as name, title, type, time_limit as timeLimit, status, shows, clicks, image_url as imageUrl
                                        FROM unit LEFT JOIN statistics_cache ON unit.unit_name = statistics_cache.unit_name
                                        WHERE status <> "delete"');
            $sth->execute();
            $units = $sth->fetchAll(PDO::FETCH_CLASS, 'Unit');

            return $units;
        } catch(PDOException $e) {
            return null;
        }
    }

    public function get($name) {
        try {
            $sth = $this->dbh->prepare('SELECT unit.unit_name as name, type, title, weight, link, image_url as imageUrl,
                                        html, shows_limit as showsLimit, clicks_limit as clicksLimit, time_limit as timeLimit, status, shows, clicks
                                        FROM unit LEFT JOIN statistics_cache ON unit.unit_name = statistics_cache.unit_name
                                        WHERE unit.unit_name = :name');

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
            $sth = $this->dbh->prepare('SELECT unit_name as name FROM unit WHERE status <> "delete"');

            $sth->execute();
            $unit = $sth->fetchAll(PDO::FETCH_COLUMN);

            return $unit;
        } catch(PDOException $e) {
            return null;
        }
    }

    public function update($unit) {
        try {
            $sth = $this->dbh->prepare('UPDATE unit SET title = :title, weight = :weight, shows_limit = :showsLimit,
                                        clicks_limit = :clicksLimit, time_limit = :timeLimit, link = :link, status = "active",
                                        html = :html' . ($unit->imageUrl ? ', image_url = :imageUrl, image_type = :imageType' : '') . ' WHERE unit_name = :name');

            $sth->bindParam(':title', $unit->title, PDO::PARAM_STR);
            $sth->bindParam(':weight', $unit->weight, PDO::PARAM_INT);
            $sth->bindParam(':showsLimit', $unit->showsLimit, PDO::PARAM_INT);
            $sth->bindParam(':clicksLimit', $unit->clicksLimit, PDO::PARAM_INT);
            $sth->bindParam(':timeLimit', $unit->timeLimit, PDO::PARAM_STR);
            $sth->bindParam(':link', $unit->link, PDO::PARAM_STR);

            if ($unit->imageUrl) {
                $sth->bindParam(':imageUrl', $unit->imageUrl, PDO::PARAM_STR);
                $sth->bindParam(':imageType', $unit->imageType, PDO::PARAM_STR);
            }

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
                                        weight = :weight, shows_limit = :showsLimit, clicks_limit = :clicksLimit,
                                        time_limit = :timeLimit, link = :link, status = "active",
                                        image_url = :imageUrl, image_type = :imageType, html = :html;');

            $sth->bindParam(':name', $unit->name, PDO::PARAM_STR);
            $sth->bindParam(':type', $unit->type, PDO::PARAM_STR);
            $sth->bindParam(':title', $unit->title, PDO::PARAM_STR);
            $sth->bindParam(':weight', $unit->weight, PDO::PARAM_INT);
            $sth->bindParam(':showsLimit', $unit->showsLimit, PDO::PARAM_INT);
            $sth->bindParam(':clicksLimit', $unit->clicksLimit, PDO::PARAM_INT);
            $sth->bindParam(':timeLimit', $unit->timeLimit, PDO::PARAM_STR);
            $sth->bindParam(':link', $unit->link, PDO::PARAM_STR);
            $sth->bindParam(':imageUrl', $unit->imageUrl, PDO::PARAM_STR);
            $sth->bindParam(':imageType', $unit->imageType, PDO::PARAM_STR);
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
