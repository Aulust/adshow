<?php

class UnitDao {
    private $dbh;
    private $config;

    public function UnitDao($dbh, $config) {
        $this->dbh = $dbh;
        $this->config = $config;
    }

    public function getAll() {
        try {
            $sth = $this->dbh->prepare('SELECT unit.unit_name as name, title, type, time_limit, status, shows, clicks, image_url
                                        FROM unit INNER JOIN statistics_cache ON unit.unit_name = statistics_cache.unit_name
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
                                        html, shows_limit, clicks_limit, time_limit, status, shows, clicks
                                        FROM unit INNER JOIN statistics_cache ON unit.unit_name = statistics_cache.unit_name
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
            $sth = $this->dbh->prepare('UPDATE unit SET title = :title, weight = :weight, shows_limit = :shows_limit,
                                        clicks_limit = :clicks_limit, time_limit = :time_limit, link = :link, status = "active",
                                        html = :html' . (($unit->imageUrl || (isset($_FILES['imageUrl']) && $_FILES["imageUrl"]["tmp_name"]!='')) ? ', image_url = :image_url, image_type = :image_type' : '') . ' WHERE unit_name = :name');

            $sth->bindParam(':title', $unit->title, PDO::PARAM_STR);
            $sth->bindParam(':weight', $unit->weight, PDO::PARAM_INT);
            $sth->bindParam(':shows_limit', $unit->shows_limit, PDO::PARAM_INT);
            $sth->bindParam(':clicks_limit', $unit->clicks_limit, PDO::PARAM_INT);
            $sth->bindParam(':time_limit', $unit->time_limit, PDO::PARAM_STR);
            $sth->bindParam(':link', $unit->link, PDO::PARAM_STR);
            
            if ($unit->imageUrl) {
                $sth->bindParam(':image_url', $unit->imageUrl, PDO::PARAM_STR);
                $sth->bindParam(':image_type', $unit->image_type, PDO::PARAM_STR);
            }
            else if(isset($_FILES['imageUrl']) && $_FILES["imageUrl"]["tmp_name"]!='') {
                $imageinfo = getimagesize($_FILES["imageUrl"]["tmp_name"]);
                $mime=explode("/",$imageinfo["mime"]);
                $unit->imageUrl = $this->config['uploadDir'] . $unit->name . '.' . $mime[1];
                move_uploaded_file($_FILES['imageUrl']['tmp_name'], '.' . $unit->imageUrl);
                $sth->bindParam(':image_url', $unit->imageUrl, PDO::PARAM_STR);
                $sth->bindParam(':image_type', $unit->image_type, PDO::PARAM_STR);
            }
            
            $sth->bindParam(':html', $unit->html, PDO::PARAM_STR);
            $sth->bindParam(':name', $unit->name, PDO::PARAM_STR);
            $sth->execute();
        } catch(PDOException $e) {var_dump(1);die();
            return false;
        }
        return true;
    }

    public function insert($unit) {
        try {
            $sth = $this->dbh->prepare('INSERT INTO unit SET unit_name = :name, type = :type, title = :title,
                                        weight = :weight, shows_limit = :shows_limit, clicks_limit = :clicks_limit,
                                        time_limit = :time_limit, link = :link, status = "active",
                                        image_url = :image_url, image_type = :image_type, html = :html;
                                        INSERT INTO statistics_cache SET unit_name = :name;');

            $sth->bindParam(':name', $unit->name, PDO::PARAM_STR);
            $sth->bindParam(':type', $unit->type, PDO::PARAM_STR);
            $sth->bindParam(':title', $unit->title, PDO::PARAM_STR);
            $sth->bindParam(':weight', $unit->weight, PDO::PARAM_INT);
            $sth->bindParam(':shows_limit', $unit->shows_limit, PDO::PARAM_INT);
            $sth->bindParam(':clicks_limit', $unit->clicks_limit, PDO::PARAM_INT);
            $sth->bindParam(':time_limit', $unit->time_limit, PDO::PARAM_STR);
            $sth->bindParam(':link', $unit->link, PDO::PARAM_STR);
            
            if(!$unit->imageUrl && isset($_FILES['imageUrl'])) {
                $imageinfo = getimagesize($_FILES["imageUrl"]["tmp_name"]);
                $mime=explode("/",$imageinfo["mime"]);
                $unit->imageUrl = $this->config['uploadDir'] . $unit->name . '.' . $mime[1];
                move_uploaded_file($_FILES['imageUrl']['tmp_name'], '.' . $unit->imageUrl);
            }
            $sth->bindParam(':image_url', $unit->imageUrl, PDO::PARAM_STR);
            $sth->bindParam(':image_type', $unit->image_type, PDO::PARAM_STR);
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
