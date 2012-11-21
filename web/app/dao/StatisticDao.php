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
            $date = $sth->fetch();
        } catch(PDOException $e) {
            return false;
        }

        return $date;
    }
    
    public function uploadStatistic($name, $start_date, $end_date, $statistic_show) {
        switch ($statistic_show) {
        case 'all': $shows=', shows'; $clicks=', clicks'; break;
        case 'shows': $shows=', shows'; $clicks=''; break;
        case 'clicks': $shows=''; $clicks=', clicks'; break;
        default: $shows=', shows'; $clicks=', clicks';
        }
        try {
            $sth = $this->dbh->prepare('SELECT date'. $shows . $clicks .' FROM `statistics` WHERE `date`>=:start_date AND `date`<=:end_date AND unit_name=:name');
            $sth->bindParam(':name', $name, PDO::PARAM_STR);
            $sth->bindParam(':start_date', $start_date, PDO::PARAM_STR);
            $sth->bindParam(':end_date', $end_date, PDO::PARAM_STR);
            $sth->execute();
            $res = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
        $result=array();
        foreach ($res as $r) {
            $result[]=join(',',$r);
        }
        $result=join("\r\n",$result);
        header('Content-type: application/CSV');
        header('Content-Disposition: attachment; filename="'.$name.'_stat.csv"');
        header('Content-Length: ' . strlen($result));
        echo $result;
        die();
    }
    
    public function showStatistic($name, $start_date, $end_date, $statistic_show) {
        switch ($statistic_show) {
        case 'all': $shows=', shows'; $clicks=', clicks'; break;
        case 'shows': $shows=', shows'; $clicks=''; break;
        case 'clicks': $shows=''; $clicks=', clicks'; break;
        default: $shows=', shows'; $clicks=', clicks';
        }
        try {
            $sth = $this->dbh->prepare('SELECT date'. $shows . $clicks .' FROM `statistics` WHERE `date`>=:start_date AND `date`<=:end_date AND unit_name=:name');
            $sth->bindParam(':name', $name, PDO::PARAM_STR);
            $sth->bindParam(':start_date', $start_date, PDO::PARAM_STR);
            $sth->bindParam(':end_date', $end_date, PDO::PARAM_STR);
            $sth->execute();
            $res = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
        $clicks = array();
        $shows = array();
        $shows_sum = 0;
        $clicks_sum = 0;
        foreach($res as $r) {
            if(isset($r['shows'])) {
                $shows[] = '["'.$r['date'].'",'.$r['shows'].']';
                $shows_sum += $r['shows'];
            }
            if(isset($r['clicks'])) {
                $clicks[] = '["'.$r['date'].'",'.$r['clicks'].']';
                $clicks_sum += $r['clicks'];
            }
        }
        $shows = join(',',$shows);
        $clicks = join(',',$clicks);
        $res=array('shows'=>$shows, 'clicks'=>$clicks, 'shows_sum'=>$shows_sum, 'clicks_sum'=>$clicks_sum);
        return $res;
    }
}
