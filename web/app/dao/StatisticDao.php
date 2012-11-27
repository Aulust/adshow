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
    
    public function getStatistic($name, $start_date, $end_date, $statistic_show) {
        $stat_select = $this->getStatisticSelect($statistic_show);
        try {
            $sth = $this->dbh->prepare("SELECT $stat_select FROM `statistics` WHERE `date`>=:start_date AND `date`<=:end_date AND unit_name=:name");
            $sth->bindParam(':name', $name, PDO::PARAM_STR);
            $sth->bindParam(':start_date', $start_date, PDO::PARAM_STR);
            $sth->bindParam(':end_date', $end_date, PDO::PARAM_STR);
            $sth->execute();
            $res = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
        
        return $res;
    }
    
    public function getStatisticSelect($statistic_show) {
        switch ($statistic_show) {
            case 'all': $fetch = array('date', 'shows', 'clicks'); break;
            case 'shows': $fetch = array('date', 'shows'); break;
            case 'clicks': $fetch = array('date', 'clicks'); break;
            default: $fetch = array('date', 'shows', 'clicks');
        }
        $res=join(',',$fetch);
        return $res;
    }
}
