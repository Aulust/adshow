<?php

class PlacementDao {
    private $dbh;

    public function PlacementDao($dbh) {
        $this->dbh = $dbh;
    }

    public function getAll() {
        try {
            $sth = $this->dbh->prepare('SELECT placement_name as name, title FROM placement');
            $sth->execute();
            $placements = $sth->fetchAll(PDO::FETCH_CLASS, 'Placement');

            return $placements;
        } catch(PDOException $e) {
            return null;
        }
    }

    public function get($name) {
        try {
            $sth = $this->dbh->prepare('SELECT placement_name as name, title, width, height
                                        FROM placement WHERE placement_name = :name');

            $sth->bindParam(':name', $name, PDO::PARAM_STR);
            $sth->execute();
            $placement = $sth->fetchObject('Placement');

            return $placement === false ? null : $placement;
        } catch(PDOException $e) {
            return null;
        }
    }

    public function update($placement) {
        try {
            $sth = $this->dbh->prepare('UPDATE placement SET title = :title, width = :width, height = :height
                                        WHERE placement_name = :name');

            $sth->bindParam(':title', $placement->title, PDO::PARAM_STR);
            $sth->bindParam(':width', $placement->width, PDO::PARAM_INT);
            $sth->bindParam(':height', $placement->height, PDO::PARAM_INT);
            $sth->bindParam(':name', $placement->name, PDO::PARAM_STR);
            $sth->execute();
        } catch(PDOException $e) {
            print_r($e);
            return false;
        }

        return true;
    }

    public function insert($placement) {
        try {
            $sth = $this->dbh->prepare('INSERT INTO placement SET placement_name = :name, title = :title,
                                        width = :width, height = :height');

            $sth->bindParam(':name', $placement->name, PDO::PARAM_STR);
            $sth->bindParam(':title', $placement->title, PDO::PARAM_STR);
            $sth->bindParam(':width', $placement->width, PDO::PARAM_INT);
            $sth->bindParam(':height', $placement->height, PDO::PARAM_INT);
            $sth->execute();
        } catch(PDOException $e) {
            return false;
        }

        return true;
    }

    public function delete($placement) {
        try {
            $sth = $this->dbh->prepare('DELETE FROM placement WHERE placement_name = :name');

            $sth->bindParam(':name', $placement->name, PDO::PARAM_STR);
            $sth->execute();
        } catch(PDOException $e) {
            return false;
        }

        return true;
    }
}
