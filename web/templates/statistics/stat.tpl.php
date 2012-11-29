<?
$clicksArray = array();
$showsArray = array();
$shows_sum = 0;
$clicks_sum = 0;
foreach($res as $r) {
    if(isset($r['shows'])) {
        $showsArray[] = '["'.$r['date'].'",'.$r['shows'].']';
        $shows_sum += $r['shows'];
    }
    if(isset($r['clicks'])) {
        $clicksArray[] = '["'.$r['date'].'",'.$r['clicks'].']';
        $clicks_sum += $r['clicks'];
    }
}
$shows = join(',',$showsArray);
$clicks = join(',',$clicksArray);
$stat=array('shows'=>$shows, 'clicks'=>$clicks, 'shows_sum'=>$shows_sum, 'clicks_sum'=>$clicks_sum);
?>
<? if($statistic_show == 'all' || $statistic_show == 'shows'):?>
    <div id="stat_shows" class="statistics"></div>
    <div>Shows: <?= $stat['shows_sum'];?></div>
<? endif ?>
<? if($statistic_show == 'all' || $statistic_show == 'clicks'):?>
    <div id="stat_clicks" class="statistics"></div>
    <div>Clicks: <?= $stat['clicks_sum'];?></div>
<? endif ?>
<script>
    var shows = <?= $stat['shows'] ? '[' . $stat['shows'] .']' : 'null' ?>;
    var clicks = <?= $stat['clicks'] ? '[' . $stat['clicks'] .']' : 'null' ?>;
    printStatistics(shows, clicks);
</script>
