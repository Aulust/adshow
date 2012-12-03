<?php

class BindingDao {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    public function getUnitNamesByPlacement($placement) {
        try {
            $sth = $this->dbh->prepare('SELECT unit_name as name FROM bindings WHERE placement_name = :name');

            $sth->bindParam(':name', $placement->name, PDO::PARAM_STR);
            $sth->execute();
            $units = $sth->fetchAll(PDO::FETCH_COLUMN);

            return $units;
        } catch(PDOException $e) {
            return null;
        }
    }

    public function getUnitsByPlacement($placement) {
        try {
            $sth = $this->dbh->prepare('SELECT unit.unit_name as name, type, title, weight, link, image_url as imageUrl, html, status
                                        FROM unit INNER JOIN bindings ON unit.unit_name = bindings.unit_name
                                        WHERE placement_name = :name');

            $sth->bindParam(':name', $placement->name, PDO::PARAM_STR);
            $sth->execute();
            $units = $sth->fetchAll(PDO::FETCH_CLASS, 'Unit');

            return $units;
        } catch(PDOException $e) {
            return null;
        }
    }

    public function deleteByUnit($unit) {
        try {
            $sth = $this->dbh->prepare('DELETE FROM bindings WHERE unit_name = :name');

            $sth->bindParam(':name', $unit->name, PDO::PARAM_STR);
            $sth->execute();
        } catch(PDOException $e) {
            return false;
        }

        return true;
    }

    public function setBindingForPlacement($placement, $unitNames) {
        try {
            $sth = $this->dbh->prepare('DELETE FROM bindings WHERE placement_name = :name');

            $sth->bindParam(':name', $placement->name, PDO::PARAM_STR);
            $sth->execute();

            $sth = $this->dbh->prepare('INSERT INTO bindings VALUES (:placementName, :unitName)');

            foreach($unitNames as $unitName) {
                $sth->bindParam(':placementName', $placement->name, PDO::PARAM_STR);
                $sth->bindParam(':unitName', $unitName, PDO::PARAM_STR);
                $sth->execute();
            }
        } catch(PDOException $e) {
            return false;
        }

        return true;
    }
}
