<?php

class StatisticDao {
    private $dbh;

    public function StatisticDao($dbh) {
        $this->dbh = $dbh;
    }
    
    public function getStartDate($name) {
        try {
            $sth = $this->dbh->prepare('SELECT MIN(date) FROM `statistics` WHERE unit_name=:name');
            $sth->bindParam(':name', $name, PDO::PARAM_STR);
            $sth->execute();
            $date = $sth->fetchColumn();
        } catch(PDOException $e) {
            return false;
        }

        return $date;
    }
    
    public function getStatistic($name, $startDate, $endDate, $statisticShow) {
        $statSelect = $this->getStatisticSelect($statisticShow);
        try {
            $sth = $this->dbh->prepare("SELECT $statSelect FROM `statistics` WHERE `date`>=:startDate AND `date`<=:endDate AND unit_name=:name");
            $sth->bindParam(':name', $name, PDO::PARAM_STR);
            $sth->bindParam(':startDate', $startDate, PDO::PARAM_STR);
            $sth->bindParam(':endDate', $endDate, PDO::PARAM_STR);
            $sth->execute();
            $res = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
        
        return $res;
    }
    
    public function getStatisticSelect($statisticShow) {
        switch ($statisticShow) {
            case 'all': $fetch = array('date', 'shows', 'clicks'); break;
            case 'shows': $fetch = array('date', 'shows'); break;
            case 'clicks': $fetch = array('date', 'clicks'); break;
            default: $fetch = array('date', 'shows', 'clicks');
        }
        $res=join(',',$fetch);
        return $res;
    }
}
